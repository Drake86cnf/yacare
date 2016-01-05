<?php
namespace Yacare\ComercioBundle\Helper;

use Doctrine\ORM\Event\LifecycleEventArgs;

/**
 * Maneja los eventos "lyfecycle" para actuar ante cambios en las actas de los comercios.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class ActaComercioHelper extends \Yacare\BaseBundle\Helper\Helper
{
    function __construct($listener = null, $em = null)
    {
        parent::__construct($listener, $em);
    }
    
    public function PreUpdatePersist($actacomercio, $args = null) {
        $Comercio = $actacomercio->getComercio();
        $Comercio->setFechaUltimaActa($actacomercio->getFecha());
        $this->em->persist($Comercio);
    }
}
