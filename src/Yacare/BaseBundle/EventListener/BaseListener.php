<?php
namespace Yacare\BaseBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\Common\EventSubscriber;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Tapir\BaseBundle\EventListener\AbstractListener;

/**
 * Escucha los eventos "lifecycle" de Doctrine para intervenir durante la creación o modificación de ciertas entidades.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class BaseListener extends \Tapir\BaseBundle\EventListener\AbstractListener
{
    public function __construct(Container $container)
    {
        parent::__construct($container);
        
        $this->Helpers = [
            '\Yacare\BaseBundle\Entity\Persona' => '\Yacare\BaseBundle\Helper\PersonaHelper',
        ];
    }
}
