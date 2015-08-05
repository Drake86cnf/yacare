<?php
namespace Tapir\BaseBundle\ORM\Auditable;

use Doctrine\ORM\Event\LifecycleEventArgs, Doctrine\Common\EventSubscriber, Doctrine\ORM\Event\OnFlushEventArgs, Doctrine\ORM\Events;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;

/**
 * Escucha los eventos "lifecycle" de Doctrine para generar registros de auditoría para aquellas entidades que tienen
 * el trait Auditable.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class AuditableListener implements EventSubscriber
{
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function postPersist(LifecycleEventArgs $eventArgs)
    {
        $em = $eventArgs->getEntityManager();
        $entity = $eventArgs->getEntity();
        $classMetadata = $em->getClassMetadata(get_class($entity));
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        
        if ($this->isEntitySupported($classMetadata->reflClass)) {
            $Registro = new \Tapir\BaseBundle\Entity\AuditoriaRegistro();
            $Registro->setAccion('crear');
            $Registro->setElementoTipo($classMetadata->reflClass->getName());
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
        $em = $eventArgs->getEntityManager();
        $uow = $em->getUnitOfWork();
        $entity = $eventArgs->getEntity();
        $classMetadata = $em->getClassMetadata(get_class($entity));
        $user = $this->container->get('security.context')->getToken()->getUser();
        
        if ($this->isEntitySupported($classMetadata->reflClass)) {
            $uow->computeChangeSet($classMetadata, $entity);
            $changeSet = $uow->getEntityChangeSet($entity);
            
            $Registro = new \Tapir\BaseBundle\Entity\AuditoriaRegistro();
            $Registro->setAccion('editar');
            $Registro->setElementoTipo($classMetadata->reflClass->getName());
            $Registro->setElementoId($entity->getId());
            $Registro->setEstacion($this->container->get('request')->getClientIp());
            $Registro->setUsuario($user->getId());
            $Registro->setCambios(json_encode($changeSet));
            $em->persist($Registro);
            $em->flush();
        }
    }

    public function preRemove(LifecycleEventArgs $eventArgs)
    {
        $em = $eventArgs->getEntityManager();
        $entity = $eventArgs->getEntity();
        $classMetadata = $em->getClassMetadata(get_class($entity));
        $user = $this->container->get('security.context')->getToken()->getUser();
        
        if ($this->isEntitySupported($classMetadata->reflClass)) {
            $Registro = new \Tapir\BaseBundle\Entity\AuditoriaRegistro();
            $Registro->setAccion('eliminar');
            $Registro->setElementoTipo($classMetadata->reflClass->getName());
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
     * @param ReflectionClass $reflClass            
     * @return boolean
     */
    protected function isEntitySupported(\ReflectionClass $reflClass)
    {
        return \Tapir\BaseBundle\Helper\ClassHelper::UsaTrait($reflClass->getName(), 'Tapir\BaseBundle\Entity\Auditable');
    }

    public function getSubscribedEvents()
    {
        $events = [Events::postPersist,Events::postUpdate,Events::preRemove];
        
        return $events;
    }
}
