<?php
namespace Yacare\ObrasParticularesBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\Common\EventSubscriber;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;

/**
 * Escucha los eventos "lifecycle" de Doctrine para intervenir durante la creación o modificación de ciertas entidades.
 *
 * @author Ezequiel Riquelme <rezequiel.tdf@gmail.com>
 */
class ObrasParticularesListener extends \Yacare\BaseBundle\EventListener\BaseListener
{
    public function __construct(Container $container)
    {
        parent::__construct($container);
        
        $this->Helpers = [
            '\Yacare\ObrasParticularesBundle\Entity\ActaObra' => '\Yacare\ObrasParticularesBundle\Helper\ActaObraHelper',
            '\Yacare\ObrasParticularesBundle\Entity\TramiteCat' => '\Yacare\ObrasParticularesBundle\Helper\TramiteCatHelper',
            '\Yacare\ObrasParticularesBundle\Entity\Cat' => '\Yacare\ObrasParticularesBundle\Helper\CatHelper',
            '\Yacare\ObrasParticularesBundle\Entity\TramitePlano' => '\Yacare\ObrasParticularesBundle\Helper\TramitePlanoHelper',
        ];
    }
}
