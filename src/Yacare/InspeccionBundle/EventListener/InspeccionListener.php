<?php
namespace Yacare\InspeccionBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\Common\EventSubscriber;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;

/**
 * Escucha los eventos "lifecycle" de Doctrine para intervenir durante la creación o modificación de ciertas entidades.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class InspeccionListener extends \Tapir\BaseBundle\EventListener\AbstractListener
{
    public function __construct(Container $container)
    {
        parent::__construct($container);
        
        $this->Helpers = [
            '\Yacare\InspeccionBundle\Entity\Acta' => '\Yacare\InspeccionBundle\Helper\ActaHelper',
        ];
    }
}
