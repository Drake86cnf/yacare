<?php
namespace Yacare\BaseBundle\Helper;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Tapir\BaseBundle\Helper\BaseHelper;

/**
 * Maneja los eventos "lyfecycle" para actuar ante ciertos cambios en las entidades.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
abstract class AbstractHelper extends \Tapir\BaseBundle\Helper\AbstractHelper
{
    function __construct($listenerOrContainer = null, $em = null)
    {
        parent::__construct($listenerOrContainer, $em);
    }
}
