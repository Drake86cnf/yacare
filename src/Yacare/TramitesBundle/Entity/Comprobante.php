<?php

namespace Yacare\TramitesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\TramitesBundle\Entity\Comprobante
 *
 * @ORM\Entity(repositoryClass="Yacare\BaseBundle\Entity\YacareBaseRepository")
 * @ORM\Table(name="Tramites_Comprobantes")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="ComprobanteTipo", type="string")
 * @ORM\DiscriminatorMap({
 *      "\Yacare\ComercioBundle\Entity\CertificadoHabilitacionComercial" = "\Yacare\ComercioBundle\Entity\CertificadoHabilitacionComercial"
 * })
 */
class Comprobante
{
    use \Yacare\BaseBundle\Entity\ConId;
    use \Yacare\BaseBundle\Entity\ConNombre;
    use \Yacare\BaseBundle\Entity\Versionable;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;

    use \Yacare\TramitesBundle\Entity\ConTitular;
    
    /**
     * @ORM\ManyToOne(targetEntity="ComprobanteTipo")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $ComprobanteTipo;
    
    /**
     * @ORM\ManyToOne(targetEntity="Tramite")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $TramiteOrigen;

    /**
     * @ORM\Column(type="integer")
     */
    private $NumeroPrefijo = 0;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $Numero;
    
    
    protected function ConstruirNombre() {
        if($this->getComprobanteTipo()) {
            $res = $this->getComprobanteTipo()->getNombre();
        } else {
            $res = 'Comprob. ';
        }
        $res .= ' Nº ';
        if($this->getNumeroPrefijo()) {
            $res .=  str_pad($this->getNumeroPrefijo(), 4, '0', STR_PAD_LEFT) . '-';
        }
        $res .=  $this->getNumero();
        
        return $res;
    }

    


    public function getComprobanteTipo() {
        return $this->ComprobanteTipo;
    }

    public function getNumeroPrefijo() {
        return $this->NumeroPrefijo;
    }

    public function getNumero() {
        return $this->Numero;
    }

    public function setComprobanteTipo($ComprobanteTipo) {
        $this->ComprobanteTipo = $ComprobanteTipo;
    }

    public function setNumeroPrefijo($NumeroPrefijo) {
        $this->NumeroPrefijo = $NumeroPrefijo;
        $this->setNombre($this->ConstruirNombre());
    }

    public function setNumero($Numero) {
        $this->Numero = $Numero;
        $this->setNombre($this->ConstruirNombre());
    }
    
    public function getTramiteOrigen() {
        return $this->TramiteOrigen;
    }

    public function setTramiteOrigen($TramiteOrigen) {
        $this->TramiteOrigen = $TramiteOrigen;
    }
}
