<?php

namespace Yacare\ComercioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\ComercioBundle\Entity\CertificadoHabilitacionComercial
 *
 * @ORM\Entity(repositoryClass="Yacare\BaseBundle\Entity\YacareBaseRepository")
 * @ORM\Table(name="Comercio_CertificadoHabilitacionComercial")
 */
class CertificadoHabilitacionComercial extends \Yacare\TramitesBundle\Entity\Comprobante
{
    use \Yacare\TramitesBundle\Entity\ConVencimiento;
    
    /**
     * @ORM\ManyToOne(targetEntity="Yacare\ComercioBundle\Entity\Comercio")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=false)
     */
    protected $Comercio;
    
    
    public function getComercio() {
        return $this->Comercio;
    }

    public function setComercio($Comercio) {
        $this->Comercio = $Comercio;
    }
}
