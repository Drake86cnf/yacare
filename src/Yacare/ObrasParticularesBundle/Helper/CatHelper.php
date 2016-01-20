<?php
namespace Yacare\ObrasParticularesBundle\Helper;


class CatHelper extends \Yacare\BaseBundle\Helper\Helper
{
    function __construct($listener = null, $em = null)
    {
        parent::__construct($listener, $em);
    }

    public function PreUpdatePersist($entity, $args = null)
    {
        // Al crear un CAT, tomo el local del TramiteCat que lo generó
        $TramiteOrigen = $entity->getTramiteOrigen();
        if($TramiteOrigen) {
            $Local = $TramiteOrigen->getComercio()->getLocal();
            $entity->setLocal($Local);
        }
    }
}
