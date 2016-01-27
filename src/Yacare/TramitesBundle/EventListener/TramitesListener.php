<?php
namespace Yacare\TramitesBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PostFlushEventArgs;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;

/**
 * Escucha los eventos "lifecycle" de Doctrine para intervenir durante la creación o modificación de ciertas entidades.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class TramitesListener extends \Tapir\BaseBundle\EventListener\AbstractListener
{
    public function __construct(Container $container)
    {
        parent::__construct($container);
        
        $this->Helpers = [
            '\Yacare\TramitesBundle\Entity\Tramite' => '\Yacare\TramitesBundle\Helper\TramiteHelper',
            '\Yacare\TramitesBundle\Entity\TramiteTipo' => '\Yacare\TramitesBundle\Helper\TramiteTipoHelper',
            '\Yacare\TramitesBundle\Entity\EstadoRequisito' => '\Yacare\TramitesBundle\Helper\EstadoRequisitoHelper',
        ];
    }
  
}
