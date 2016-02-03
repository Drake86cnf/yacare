<?php
namespace Yacare\ObrasParticularesBundle\Helper;

class TramitePlanoHelper extends \Yacare\BaseBundle\Helper\AbstractHelper
{
    function __construct($listener = null, $em = null)
    {
        parent::__construct($listener, $em);
    }

    public function PreUpdatePersist($entity, $args = null)
    {
        $entity->setTitular($entity->getPartida()->getTitular());
        
        if (! $entity->getTramiteTipo()) {
            // La propiedad ActaTipo está en blanco... es normal al crear un acta nueva
            // Busco el ActaTipo que corresponde a la clase y lo guardo
            
            $NombreClase = '\\' . get_class($entity);
            $TramiteTipo = $this->em->getRepository('YacareTramitesBundle:TramiteTipo')->findOneBy(
                array('Clase' => $NombreClase));
            
            $entity->setTramiteTipo($TramiteTipo);
        }

        switch($entity->getTipo()) {
            case 'Relevamiento':
                $entity->setSuperficieProyectada(0);
                $entity->setSuperficieAprobada(0);
                break;
            case 'Conforme a obra':
                $entity->setSuperficieProyectada(0);
                break;
            case 'Obra nueva':
                $entity->setSuperficieAprobada(0);
                $entity->setSuperficieRelevada(0);
                break;
            case 'Relevamiento y ampliación':
                $entity->setSuperficieAprobada(0);
                break;
        }
    }
}
