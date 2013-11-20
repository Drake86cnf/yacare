<?php

namespace Yacare\ComercioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\ComercioBundle\Entity\CertificadoHabilitacionComercial
 *
 * @ORM\Entity
 * @ORM\Table(name="Comercio_CertificadoHabilitacionComercial")
 */
class CertificadoHabilitacionComercial extends \Yacare\TramitesBundle\Entity\Comprobante
{
    use \Yacare\ComercioBundle\Entity\ConDatosComercio;
    use \Yacare\TramitesBundle\Entity\ConVencimiento;
}
