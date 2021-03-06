<?php
namespace Tapir\BaseBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PostFlushEventArgs;
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
    
    /**
     * Guarda una colección de los registros de auditoría de nuevos registros sobre los cuales no se tiene el id.
     */
    private $InsercionesSinId = array();
    
    /**
     * Indica que hay que hacer un flush adicional.
     * 
     * Puntualmente, es para modificar entidades en el postPersist, para poder obtener los ID de las nuevas entidades
     * que no estaban disponibles en el onFlush.
     * 
     * @see $InsercionesSinId
     * @see postPersist() postFlush()
     */
    private $FlushPostFlush = false;
    
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Interviene la modificación, creación o eliminación de una entidad para generar un registro de auditoría.
     *
     * @param OnFlushEventArgs $args
     */
    public function onFlush(OnFlushEventArgs $args) 
    {
        $em = $args->getEntityManager();
        $uow = $em->getUnitOfWork();
        if($this->container->get('security.token_storage')->getToken()) {
            $UsuarioConectado = $this->container->get('security.token_storage')->getToken()->getUser();
        } else {
            // A veces no hay usuario conectado, por ejemplo al correr servicios desde la línea de comandos
            $UsuarioConectado = null;
        }

        // FIXME: las inserciones se guardan sin ID.
        $Entidades = $uow->getScheduledEntityInsertions();
        foreach ($Entidades as $Entidad) {
            if ($this->isEntitySupported($Entidad)) {
                $Cambios = $uow->getEntityChangeSet($Entidad);
                $this->WriteToLogTable($em, 'insert', $Entidad, $UsuarioConectado, $Cambios);
                $this->WriteToLogFile('insert', $Entidad, $UsuarioConectado, $Cambios);
            }
        }
        
        $Entidades = $uow->getScheduledEntityUpdates();
        foreach ($Entidades as $Entidad) {
            if ($this->isEntitySupported($Entidad)) {
                $Cambios = $uow->getEntityChangeSet($Entidad);
                $this->WriteToLogTable($em, 'update', $Entidad, $UsuarioConectado, $Cambios);
                $this->WriteToLogFile('update', $Entidad, $UsuarioConectado, $Cambios);
            }
        }
        
        $Entidades = $uow->getScheduledEntityDeletions();
        foreach ($Entidades as $Entidad) {
            if ($this->isEntitySupported($Entidad)) {
                $Cambios = $uow->getEntityChangeSet($Entidad);
                $this->WriteToLogTable($em, 'delete', $Entidad, $UsuarioConectado, $Cambios);
                $this->WriteToLogFile('delete', $Entidad, $UsuarioConectado, $Cambios);
            }
        }        
    }
    

    /**
     * Genera un registro de auditoría con un detalle de los cambios realizados a la entidad.
     *
     * @param LifecycleEventArgs $eventArgs
     */
    public function WriteToLogTable($em, $action, $entity, $user, $changeSet = null)
    {
        $uow = $em->getUnitOfWork();
        $Registro = new \Tapir\BaseBundle\Entity\AuditoriaRegistro();
        $Registro->setAccion($action);
        $Registro->setElementoTipo(str_replace('Proxies\\__CG__\\', '', get_class($entity)));
        $Registro->setElementoId($entity->getId());
        if($Request = $this->container->get('request_stack')->getCurrentRequest()) {
            // A veces no hay request, por ejemplo al correr servicios desde la línea de comandos
            $Registro->setEstacion($Request->getClientIp());
        }
        if (\Tapir\BaseBundle\Helper\ClassHelper::UsaTrait($user, 'Tapir\BaseBundle\Entity\ConIdMetodos')) {
            // A veces el usuario no tiene ID (por ejemplo en el entorno de pruebas unitarias)
            $Registro->setUsuario($user);
        }
        $Registro->setCambios(json_encode($changeSet));
        $em->persist($Registro);
        $this->InsercionesSinId[] = $Registro;
        
        $cambioMetadata = $em->getClassMetadata(get_class($Registro));
        $uow->computeChangeSet($cambioMetadata, $Registro);
    }
    
    public function postPersist(LifecycleEventArgs $args) {
        if(count($this->InsercionesSinId) > 0) {
            $em = $args->getEntityManager();
            $Entidad = $args->getEntity();
            foreach ($this->InsercionesSinId as $Registro) {
                if(!$Registro->getElementoId() && $Registro->getElementoTipo() == str_replace('Proxies\\__CG__\\', '', get_class($Entidad))) {
                    $Registro->setElementoId($Entidad->getId());
                    $em->persist($Registro);
                    $this->FlushPostFlush = true;
                }
            }
        }
    }
    
    public function postFlush(PostFlushEventArgs $eventArgs)
    {
        if ($this->FlushPostFlush) {
            $this->FlushPostFlush = false;
            $eventArgs->getEntityManager()->flush();
        }
    }

    /**
     * Escribe un evento en el log.
     */
    protected function WriteToLogFile($action, $entity, $user, $changeSet = null)
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
    protected function isEntitySupported($className)
    {
        return \Tapir\BaseBundle\Helper\ClassHelper::UsaTrait($className, 'Tapir\BaseBundle\Entity\Auditable');
    }

    public function getSubscribedEvents()
    {
        return [\Doctrine\ORM\Events::onFlush, \Doctrine\ORM\Events::postPersist, \Doctrine\ORM\Events::postFlush];
    }
}
