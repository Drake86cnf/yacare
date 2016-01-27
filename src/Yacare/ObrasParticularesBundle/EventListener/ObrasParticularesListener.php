<?php
namespace Yacare\ObrasParticularesBundle\EventListener;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;

/**
 * Escucha los eventos "lifecycle" de Doctrine para intervenir durante la creación o modificación de ciertas entidades.
 *
 * @author Ezequiel Riquelme <rezequiel.tdf@gmail.com>
 */
class ObrasParticularesListener extends \Tapir\BaseBundle\EventListener\AbstractListener
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
