<?php
namespace Yacare\BaseBundle\Helper;

use Doctrine\ORM\Event\LifecycleEventArgs;

/**
 * Maneja los eventos "lyfecycle" para actuar ante ciertos cambios en las entidades.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
abstract class Helper implements IHelper
{
    protected $em;
    protected $Listener;
    protected $Entidad;
    protected $EsEdicion;
    protected $Argumentos;

    function __construct($listener = null, $em = null)
    {
        if ($listener) {
            $this->Listener = $listener;
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
    
    protected function AgregarEntidadAlConjuntoDeCambios($entidad) {
        $this->Listener->EntidadesRelacionadas[] = $entidad;
        /* $uow = $this->em->getUnitOfWork();
        $cambioMetadata = $this->em->getClassMetadata(get_class($entidad));
        
        //recomputeSingleEntityChangeSet???
        $uow->computeChangeSet($cambioMetadata, $entidad); */
    }
}
