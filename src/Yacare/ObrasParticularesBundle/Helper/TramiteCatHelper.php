<?php
namespace Yacare\ObrasParticularesBundle\Helper;


class TramiteCatHelper extends \Yacare\BaseBundle\Helper\Helper
{
    function __construct($listener = null, $em = null)
    {
        parent::__construct($listener, $em);
    }

    public function PreUpdatePersist($entity, $args = null)
    {
        if ($entity->getTramitePadre()){
            $Comercio = $entity->getTramitePadre()->getComercio();
            $entity->setComercio($Comercio);
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
