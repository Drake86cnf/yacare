<?php
namespace Yacare\BaseBundle\Helper;

use Doctrine\ORM\Event\LifecycleEventArgs;

/**
 * Maneja los eventos "lyfecycle" para actuar ante ciertos cambios en las entidades.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
abstract class Helper implements IHelper
{
    protected $em;
    
    function __construct($em = null) {
        if($em) {
            $this->em = $em;
        }
    }
    
    public function LifecycleEvent(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $this->em = $args->getEntityManager();
    
        $this->PreUpdatePersist($entity, $args);
    }
}