<?php
namespace Yacare\ComercioBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;

/**
 * Escucha los eventos "lifecycle" de Doctrine para intervenir durante la creación o modificación de ciertas entidades.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class ComercioListener extends \Tapir\BaseBundle\EventListener\AbstractListener
{
    public function __construct(Container $container)
    {
        parent::__construct($container);
        
        $this->Helpers = [
            '\Yacare\ComercioBundle\Entity\TramiteHabilitacionComercial' => '\Yacare\ComercioBundle\Helper\TramiteHabilitacionComercialHelper',
            '\Yacare\ComercioBundle\Entity\Comercio' => '\Yacare\ComercioBundle\Helper\ComercioHelper',
            '\Yacare\ComercioBundle\Entity\ActaComercio' => '\Yacare\ComercioBundle\Helper\ActaComercioHelper',
            '\Yacare\ComercioBundle\Entity\CertificadoHabilitacionComercial' => '\Yacare\ComercioBundle\Helper\CertificadoHabilitacionComercialHelper',
            '\Yacare\ComercioBundle\Entity\EstadoRequisito' => '\Yacare\ComercioBundle\Helper\EstadoRequisitoHelper',
            '\Yacare\ComercioBundle\Entity\Actividad' => '\Yacare\ComercioBundle\Helper\ActividadHelper',
        ];
    }
}
