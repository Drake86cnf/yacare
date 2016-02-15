<?php
namespace Tapir\BaseBundle\Helper;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreFlushEventArgs;

/**
 * Maneja los eventos "lyfecycle" para actuar ante ciertos cambios en las entidades.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
abstract class AbstractHelper
{
    protected $em;
    protected $container;
    
    protected $Entidad;
    protected $EsEdicion;
    protected $Argumentos;
    public $EntidadesRelacionadas = array();

    function __construct($listenerOrContainer = null, $em = null)
    {
        if (is_a($listenerOrContainer, 'Doctrine\Common\EventSubscriber')) {
            $this->Listener = $listenerOrContainer;
        } else {
            $this->container = $listenerOrContainer;
        }
        if ($em) {
            $this->em = $em;
        }
    }

    /**
     * Atrapa llamadas de lifecycle, extrae la entidad y el EM y llama a una función propia.
     * 
     * @param LifecycleEventArgs $args
     */
    public function LifecycleEvent(LifecycleEventArgs $args)
    {
        $this->em = $args->getEntityManager();
        $this->Entidad = $args->getEntity();
        $this->Argumentos = $args;
        $this->EsEdicion = is_a($this->Argumentos, 'Doctrine\ORM\Event\PreUpdateEventArgs');
        
        $this->PreUpdatePersist($this->Entidad, $args);
    }
    
    public function preFlush(PreFlushEventArgs $args)
    {
        
    }
    
    /**
     * Agrega una entidad al conjunto de cambios para hacer un flush() al final.
     * @param unknown $entidad
     */
    protected function AgregarEntidadAlConjuntoDeCambios($entidad) {
        $this->EntidadesRelacionadas[] = $entidad;
    }

    /**
     * @ignore
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * @ignore
     */
    public function setContainer($container)
    {
        $this->container = $container;
        return $this;
    }
 
}
