<?php
namespace Yacare\ObrasParticularesBundle\Helper;


class TramiteCatHelper extends \Yacare\BaseBundle\Helper\AbstractHelper
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
            $entity->setNombre('CAT-Ed de ' . (string)$Comercio);
        } else {
            // Ponerle nombre al trámite
            $NombreCat = $entity->getTramitePadre()
                ->getComercio()
                ->getLocal()
                ->getPartida()
                ->getTitular();
            $entity->setNombre($NombreCat);
            $entity->setNombre('CAT-Ed de ' . $NombreCat);
        }
    }
}
