<?php
namespace Tapir\BaseBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\Common\EventArgs;
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

    /**
     * Interviene la creación de una entidad para generar un registro de auditoría.
     *
     * @param LifecycleEventArgs $eventArgs
     */
    public function postPersist(LifecycleEventArgs $eventArgs)
    {
        return $this->logChangeSet($eventArgs, 'crear');
    }

    /**
     * Interviene la modificación de una entidad para generar un registro de auditoría.
     *
     * @param LifecycleEventArgs $eventArgs
     */
    public function postUpdate(LifecycleEventArgs $eventArgs)
    {
        return $this->logChangeSet($eventArgs, 'editar');
    }

    /**
     * Interviene la eliminación de una entidad para generar un registro de auditoría.
     *
     * @param LifecycleEventArgs $eventArgs
     */
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
            if (\Tapir\BaseBundle\Helper\ClassHelper::UsaTrait($user, 'Tapir\BaseBundle\Entity\ConIdMetodos')) {
                $Registro->setUsuario($user->getId());
            }
            $em->persist($Registro);
            $em->flush();

            $this->WriteToLog('eliminar', $entity, $user);
        }
    }

    /**
     * Genera un registro de auditoría con un detalle de los cambios realizados a la entidad.
     *
     * @param LifecycleEventArgs $eventArgs
     */
    public function logChangeSet(LifecycleEventArgs $eventArgs, $action)
    {
        $em = $eventArgs->getEntityManager();
        $uow = $em->getUnitOfWork();
        $entity = $eventArgs->getEntity();
        $classMetadata = $em->getClassMetadata(get_class($entity));
        $user = $this->container->get('security.context')->getToken()->getUser();

        if ($this->isEntitySupported($classMetadata->reflClass)) {
            $uow->computeChangeSet($classMetadata, $entity);
            $changeSet = $uow->getEntityChangeSet($entity);

            $this->WriteToLog($action, $entity, $user, $changeSet);

            $Registro = new \Tapir\BaseBundle\Entity\AuditoriaRegistro();
            $Registro->setAccion($action);
            $Registro->setElementoTipo($classMetadata->reflClass->getName());
            $Registro->setElementoId($entity->getId());
            $Registro->setEstacion($this->container->get('request')->getClientIp());
            if (\Tapir\BaseBundle\Helper\ClassHelper::UsaTrait($user, 'Tapir\BaseBundle\Entity\ConIdMetodos')) {
                // Algunas veces el usuario no tiene ID (por ejemplo en el entorno de pruebas unitarias)
                $Registro->setUsuario($user->getId());
            }
            //echo '<pre>' . json_encode($changeSet, JSON_PRETTY_PRINT) . '</pre>';
            $Registro->setCambios(json_encode($changeSet));
            $em->persist($Registro);
            $em->flush();
            //$em->clear();
            //$RegistroMeta = $em->getClassMetadata(get_class($Registro));
            //$uow->computeChangeSet($RegistroMeta, $Registro);
        }
    }

    /**
     * Escribe un evento en el log.
     */
    protected function WriteToLog($action, $entity, $user, $changeSet = null)
    {
        if (\Tapir\BaseBundle\Helper\ClassHelper::UsaTrait($user, 'Tapir\BaseBundle\Entity\ConIdMetodos')) {
            $logUser = $user->getId();
        } else {
            $logUser = (string) $user;
        }

        $log = $this->container->get('audit.logger');
        $log->addInfo(
            $action . ' ' . get_class($entity) . ' ' . $entity->getId() . ' ' . $logUser . ' ' .
                 json_encode($changeSet, JSON_PRETTY_PRINT));
    }

    /**
     * Devuelve true si la clase es auditable.
     *
     * @param ReflectionClass $reflClass
     * @return boolean True si la clase es auditable.
     */
    protected function isEntitySupported(\ReflectionClass $reflClass)
    {
        return \Tapir\BaseBundle\Helper\ClassHelper::UsaTrait($reflClass->getName(),
            'Tapir\BaseBundle\Entity\Auditable');
    }

    public function getSubscribedEvents()
    {
        return [\Doctrine\ORM\Events::postPersist, \Doctrine\ORM\Events::postUpdate, \Doctrine\ORM\Events::preRemove];
    }
}
