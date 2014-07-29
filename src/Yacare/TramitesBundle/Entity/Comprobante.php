<?php

namespace Yacare\TramitesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Clase base para comprobantes.
 * 
 * Un comprobante tiene titular, tipo, fecha y número y normalmente es el
 * resultado de un trámite.
 * 
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Table(name="Tramites_Comprobantes")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="ComprobanteTipo", type="string")
 * @ORM\DiscriminatorMap({
 *      "\Yacare\ComercioBundle\Entity\CertificadoHabilitacionComercial" = "\Yacare\ComercioBundle\Entity\CertificadoHabilitacionComercial",
 *      "\Yacare\ObrasParticularesBundle\Entity\Cat" = "\Yacare\ObrasParticularesBundle\Entity\Cat"
 * })
 */
abstract class Comprobante
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Tapir\BaseBundle\Entity\ConNombre;
    use \Tapir\BaseBundle\Entity\Versionable;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;

    use \Yacare\TramitesBundle\Entity\ConTitular;
    
    /**
     * El tipo de comprobante.
     * 
     * @see ComprobanteTipo
     * 
     * @ORM\ManyToOne(targetEntity="ComprobanteTipo")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $ComprobanteTipo;
    
    /**
     * El trámite que dió origen a este comprobante.
     * 
     * @see Tramite
     * 
     * @ORM\ManyToOne(targetEntity="Tramite")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $TramiteOrigen;

    /**
     * El prefijo del número de comprobante.
     * 
     * Funciona como el punto de venta en las facturas. Sirve para que pueda haber
     * varias numeraciones para un mismo tipo de comprobante.
     * Por ejemplo 0001-XXXXXXX, 0002-XXXXXXX, 0003-XXXXXXX, etc.
     * 
     * @see $Numero
     * 
     * @ORM\Column(type="integer")
     */
    private $NumeroPrefijo = 0;
    
    /**
     * El número de comprobante.
     * 
     * Es secuencial, iniciando en 1 para cada prefijo y tipo de comprobante.
     * 
     * @see $NumeroPrefijo
     * 
     * @ORM\Column(type="integer")
     */
    private $Numero;
    
    
    /**
     * Crea un nombre para el comprobante, a partir del tipo, prefijo y número.
     * 
     * Por ejemplo "Certificado de habilitación Nº 1"
     * o "Recibo de pago Nº 0001-00000001".
     * 
     * @return type
     */
    protected function ConstruirNombre() {
        if ($this->getComprobanteTipo()) {
            $res = $this->getComprobanteTipo()->getNombre();
        } else {
            $res = 'Comprob. ';
        }
        $res .= ' Nº ';
        if ($this->getNumeroPrefijo()) {
            $res .=  str_pad($this->getNumeroPrefijo(), 4, '0', STR_PAD_LEFT) . '-';
            $res .=  str_pad($this->getNumero(), 8, '0', STR_PAD_LEFT);
        } else {
            $res .=  $this->getNumero();
        }
        
        return $res;
    }

    public function setNumeroPrefijo($NumeroPrefijo) {
        $this->NumeroPrefijo = $NumeroPrefijo;
        $this->setNombre($this->ConstruirNombre());
    }

    public function setNumero($Numero) {
        $this->Numero = $Numero;
        $this->setNombre($this->ConstruirNombre());
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
    
    public function getTramiteOrigen() {
        return $this->TramiteOrigen;
    }

    public function setTramiteOrigen($TramiteOrigen) {
        $this->TramiteOrigen = $TramiteOrigen;
    }
}
