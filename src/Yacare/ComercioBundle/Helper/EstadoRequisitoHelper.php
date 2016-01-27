<?php
namespace Yacare\ComercioBundle\Helper;

use Doctrine\ORM\Event\LifecycleEventArgs;

/**
 * Maneja los eventos "lyfecycle" para actuar ante ciertos cambios en los estados de los requisitos de un trámite.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class EstadoRequisitoHelper extends \Yacare\BaseBundle\Helper\AbstractHelper
{
    function __construct($listener = null, $em = null)
    {
        parent::__construct($listener, $em);
    }
    
    public function PreUpdatePersist($entity, $args = null) {
        $Tramite = $entity->getTramite();
        if (is_a($Tramite, '\Yacare\ComercioBundle\Entity\TramiteHabilitacionComercial')) {
            
        }
    }
}
