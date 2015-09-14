<?php
namespace Yacare\ComercioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Representa un Certificado de Habilitación Comercial.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 *
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Table(name="Comercio_CertificadoHabilitacionComercial")
 */
class CertificadoHabilitacionComercial extends \Yacare\TramitesBundle\Entity\Comprobante
{
    use \Yacare\BaseBundle\Entity\ConFechaValidezHasta;
    
    /**
     * @var Comercio
     * 
     * @ORM\ManyToOne(targetEntity="Yacare\ComercioBundle\Entity\Comercio")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=false)
     */
    protected $Comercio;

    public function getComercio()
    {
        return $this->Comercio;
    }

    public function setComercio($Comercio)
    {
        $this->Comercio = $Comercio;
    }
}
