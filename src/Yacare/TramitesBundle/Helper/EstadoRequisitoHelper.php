<?php
namespace Yacare\TramitesBundle\Helper;

use Doctrine\ORM\Event\LifecycleEventArgs;

/**
 * Maneja los eventos "lyfecycle" para actuar ante ciertos cambios en los estados de los requisitos de un trámite.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class EstadoRequisitoHelper extends \Yacare\BaseBundle\Helper\Helper
{
    function __construct($em = null) {
        parent::__construct($em);
    }
    
    public function PreUpdatePersist($entity, $args = null) {
    }
}
