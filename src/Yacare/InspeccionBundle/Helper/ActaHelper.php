<?php
namespace Yacare\InspeccionBundle\Helper;

use Doctrine\ORM\Event\LifecycleEventArgs;

/**
 * Maneja los eventos "lyfecycle" para actuar ante ciertos cambios en las actas.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class ActaHelper extends \Yacare\BaseBundle\Helper\Helper
{
    function __construct($em = null) {
        parent::__construct($em);
    }
    
    public function PreUpdatePersist($entity, $args = null) {
        if (! $entity->getActaTipo()) {
            // La propiedad ActaTipo está en blanco... es normal al crear un acta nueva
            // Busco el ActaTipo que corresponde a la clase y lo guardo
        
            $NombreClase = '\\' . get_class($entity);
            $ActaTipo = $this->em->getRepository('YacareInspeccionBundle:ActaTipo')->findOneBy(
                array('Clase' => $NombreClase));
        
            $entity->setActaTipo($ActaTipo);
        }
    }
}
