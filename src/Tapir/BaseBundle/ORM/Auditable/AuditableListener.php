<?php
namespace Tapir\BaseBundle\ORM\Auditable;

use Doctrine\ORM\Event\LifecycleEventArgs,
    Doctrine\Common\EventSubscriber,
    Doctrine\ORM\Event\OnFlushEventArgs,
    Doctrine\ORM\Events;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;

/**
 * AuditableListener escucha los eventos "lifecycle" de Doctrine.
 */
class AuditableListener implements EventSubscriber
{
    private $container;

    public function __construct(Container $container) {
        $this->container = $container;
    }

    public function postPersist(LifecycleEventArgs $eventArgs)
    {
        $em            = $eventArgs->getEntityManager();
        $entity        = $eventArgs->getEntity();
        $classMetadata = $em->getClassMetadata(get_class($entity));
        $user          = $this->container->get('security.context')->getToken()->getUser();

        if ($this->isEntitySupported($classMetadata->reflClass)) {
            $Registro = new \Tapir\BaseBundle\Model\Auditable\Registro();
            $Registro->setAccion('crear');
            $Registro->setElementoTipo($classMetadata->reflClass);
            $Registro->setElementoId($entity->getId());
            $Registro->setEstacion($this->container->get('request')->getClientIp());
            $Registro->setUsuario($user->getId());
            $em->persist($Registro);
            $em->flush();
        }

        return $this->logChangeSet($eventArgs);
    }

    public function postUpdate(LifecycleEventArgs $eventArgs)
    {
        return $this->logChangeSet($eventArgs);
    }

    /**
     * Logs entity changeset
     *
     * @param LifecycleEventArgs $eventArgs
     */
    public function logChangeSet(LifecycleEventArgs $eventArgs)
    {
        $em            = $eventArgs->getEntityManager();
        $uow           = $em->getUnitOfWork();
        $entity        = $eventArgs->getEntity();
        $classMetadata = $em->getClassMetadata(get_class($entity));
        $user          = $this->container->get('security.context')->getToken()->getUser();

        if ($this->isEntitySupported($classMetadata->reflClass)) {
            $uow->computeChangeSet($classMetadata, $entity);
            $changeSet = $uow->getEntityChangeSet($entity);

            $Registro = new \Tapir\BaseBundle\Model\Auditable\Registro();
            $Registro->setAccion('editar');
            $Registro->setElementoTipo($classMetadata->reflClass);
            $Registro->setElementoId($entity->getId());
            $Registro->setEstacion($this->container->get('request')->getClientIp());
            $Registro->setUsuario($user->getId());
            $Registro->setExtra($changeSet);
            $em->persist($Registro);
            $em->flush();
        }
    }

    public function preRemove(LifecycleEventArgs $eventArgs)
    {
        $em            = $eventArgs->getEntityManager();
        $entity        = $eventArgs->getEntity();
        $classMetadata = $em->getClassMetadata(get_class($entity));
        $user          = $this->container->get('security.context')->getToken()->getUser();

        if ($this->isEntitySupported($classMetadata->reflClass)) {
            $Registro = new \Tapir\BaseBundle\Model\Auditable\Registro();
            $Registro->setAccion('eliminar');
            $Registro->setElementoTipo($classMetadata->reflClass);
            $Registro->setElementoId($entity->getId());
            $Registro->setEstacion($this->container->get('request')->getClientIp());
            $Registro->setUsuario($user->getId());
            $em->persist($Registro);
            $em->flush();
        }
    }

    /**
     * Verifica si la clase es auditable.
     *
     * @param  ReflectionClass $reflClass
     * @return boolean
     */
    protected function isEntitySupported(\ReflectionClass $reflClass)
    {
        return \Tapir\BaseBundle\Helper\ClassHelper::UsaTrait($reflClass, 'Tapir\BaseBundle\Model\Ausitable\Auditable');
    }

    public function getSubscribedEvents()
    {
        $events = [
            Events::postPersist,
            Events::postUpdate,
            Events::preRemove,
        ];

        return $events;
    }
}
