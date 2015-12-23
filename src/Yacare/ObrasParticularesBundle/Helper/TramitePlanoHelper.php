<?php
namespace Yacare\ObrasParticularesBundle\Helper;

class TramitePlanoHelper extends \Yacare\BaseBundle\Helper\Helper
{
    function __construct($em = null)
    {
        parent::__construct($em);
    }

    public function PreUpdatePersist($entity, $args = null)
    {
        if (! $entity->getTramiteTipo()) {
            // La propiedad ActaTipo está en blanco... es normal al crear un acta nueva
            // Busco el ActaTipo que corresponde a la clase y lo guardo
            
            $NombreClase = '\\' . get_class($entity);
            $TramiteTipo = $this->em->getRepository('YacareTramitesBundle:TramiteTipo')->findOneBy(
                array('Clase' => $NombreClase));
            
            $entity->setTramiteTipo($TramiteTipo);
            
            $entity->setTitular($entity->getPartida()->getTitular());
        }
    }
}
