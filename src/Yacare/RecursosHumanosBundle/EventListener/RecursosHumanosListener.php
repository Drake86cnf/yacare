<?php
namespace Yacare\RecursosHumanosBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\Common\EventSubscriber;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;

/**
 * Escucha los eventos "lifecycle" de Doctrine para intervenir durante la creación o modificación de ciertas entidades.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class RecursosHumanosListener extends \Tapir\BaseBundle\EventListener\AbstractListener
{
public function __construct(Container $container)
    {
        parent::__construct($container);
        
        $this->Helpers = [
            '\Yacare\RecursosHumanosBundle\Entity\Agente' => '\Yacare\RecursosHumanosBundle\AgenteHelper\PersonaHelper',
        ];
    }
}
