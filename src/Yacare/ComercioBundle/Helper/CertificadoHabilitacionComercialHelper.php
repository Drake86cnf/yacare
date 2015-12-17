<?php
namespace Yacare\ComercioBundle\Helper;

use Doctrine\ORM\Event\LifecycleEventArgs;

/**
 * Maneja los eventos "lyfecycle" para actuar ante cambios en los comprobantes.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class CertificadoHabilitacionComercialHelper extends \Yacare\BaseBundle\Helper\Helper
{
    function __construct($listener = null, $em = null)
    {
        parent::__construct($listener, $em);
    }
    
    public function PreUpdatePersist($comprobante, $args = null) {
        $this->AsignarComercio($comprobante);
    }
    
    public function AsignarComercio($comprobante) {
        $Tramite = $comprobante->getTramiteOrigen();
        $Comercio = $Tramite->getComercio();
        $comprobante->setComercio($Comercio);
    }
    
}
