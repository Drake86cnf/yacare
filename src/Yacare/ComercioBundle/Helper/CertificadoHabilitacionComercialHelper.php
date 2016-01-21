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
        if(!$comprobante->getComercio()) {
            // Durante la creación, no tiene un comercio asignado.
            // Asigno uno y pongo el comercio como habilitado y lo asocio con el certificado.
            $Tramite = $comprobante->getTramiteOrigen();
            $Comercio = $Tramite->getComercio();
            $Comercio->setEstado(100);
            $Comercio->setCertificadoHabilitacion($comprobante);
            if($comprobante->getFechaValidezHasta() && $comprobante->getFechaValidezHasta() > $Comercio->getFechaValidez()) {
                // Si el certificado tiene fecha de vencimiento y la fecha es mayor a la validez del comercio,
                // asigno la nueva validez al comercio
                $Comercio->setFechaValidez($comprobante->getFechaValidezHasta());
            }
            $Comercio->setFechaHabilitacion($comprobante->getFecha());
            $comprobante->setComercio($Comercio);
        }
    }
    
}
