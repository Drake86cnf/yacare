<?php
namespace Yacare\ObrasParticularesBundle\Helper;


class TramiteCatHelper extends \Yacare\BaseBundle\Helper\Helper
{

    function __construct($em = null)
    {
        parent::__construct($em);
    }

    public function PreUpdatePersist($entity, $args = null)
    {
        if ($entity->getTramitePadre()){
            $Comercio = $this->em->getRepository('YacareComercioBundle:Comercio')->findOneBy(array('id', $entity->getTramitePadre()));
            $entity->setLocal($Comercio->getLocal());
            $entity->setUsoSuelo($Comercio->getLocal()
                ->getPartida()
                ->getZona());
            $entity->setTitular($Comercio->getLocal()
                ->getPartida()
                ->getTitular());
            $entity->setActividad1($Comercio->getActividad1());
            $entity->setActividad2($Comercio->getActividad2());
            $entity->setActividad3($Comercio->getActividad3());
            $entity->setActividad4($Comercio->getActividad4());
            $entity->setActividad5($Comercio->getActividad5());
            $entity->setActividad6($Comercio->getActividad6());
            
        }
        // La propiedad Nombre está predefinida por el la clase tramite... es normal al crear un tramite cat nuevo
        // Busco el Nombre que corresponde al propietario de la partida y lo guardo
        $NombreCat = $entity->getTramitePadre()
            ->getComercio()
            ->getLocal()
            ->getPartida()
            ->getTitular();
        $entity->setNombre($NombreCat);
        $entity->setNombre('Cat de ' . $NombreCat);
    }
}
