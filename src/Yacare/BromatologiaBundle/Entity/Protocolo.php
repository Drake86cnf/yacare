<?php

namespace Yacare\BromatologiaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\BromatologiaBundle\Entity\Protocolo
 *
 * @ORM\Entity(repositoryClass="Yacare\BaseBundle\Entity\YacareBaseRepository")
 * @ORM\Table(name="Bromatologia_Protocolo")
 */
class Protocolo
{
    use \Yacare\BaseBundle\Entity\ConId;
    use \Yacare\BaseBundle\Entity\Versionable;
    use \Yacare\BaseBundle\Entity\Suprimible;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    
    
    /**
     * @ORM\ManyToOne(targetEntity="Yacare\BaseBundle\Entity\Persona")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $Persona;
    
    /**
     * @ORM\ManyToMany(targetEntity="Yacare\BromatologiaBundle\Entity\TipoAnalisis")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $Analisis;
   
    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $Producto;
    
     /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $Envase;
    
    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $FechaElaboracion;
    
    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $FechaVencimiento;
    
    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $FechaRecepcion;
    
    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $Observaciones;
    
    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $ActaNumero;
    
    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $ProtocoloNumero;
    
    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $Resultado;
    
    
     public function getResultadoProtocolo() {
        switch ($this->Resultado){
            case 1:
                return 'Apto';
            case 2:
                return 'No Apto';
            default:
                return '???';
        }
    }
    
    
      public function __toString() {
        return 'Protocolo N* ' . $this->getProtocoloNumero() . ' de ' . $this->getPersona()->getNombreVisible();
    }
    
        
    
    
    public function getPersona() {
        return $this->Persona;
    }

    public function setPersona($Persona) {
        $this->Persona = $Persona;
    }

    public function getAnalisis() {
        return $this->Analisis;
    }

    public function setAnalisis($Analisis) {
        $this->Analisis = $Analisis;
    }

    public function getProducto() {
        return $this->Producto;
    }

    public function setProducto($Producto) {
        $this->Producto = $Producto;
    }

    public function getEnvase() {
        return $this->Envase;
    }

    public function setEnvase($Envase) {
        $this->Envase = $Envase;
    }

    public function getFechaElaboracion() {
        return $this->FechaElaboracion;
    }

    public function setFechaElaboracion(\DateTime $FechaElaboracion) {
        $this->FechaElaboracion = $FechaElaboracion;
    }

    public function getFechaVencimiento() {
        return $this->FechaVencimiento;
    }

    public function setFechaVencimiento(\DateTime $FechaVencimiento) {
        $this->FechaVencimiento = $FechaVencimiento;
    }

    public function getFechaRecepcion() {
        return $this->FechaRecepcion;
    }

    public function setFechaRecepcion(\DateTime $FechaRecepcion) {
        $this->FechaRecepcion = $FechaRecepcion;
    }

    public function getObservaciones() {
        return $this->Observaciones;
    }

    public function setObservaciones($Observaciones) {
        $this->Observaciones = $Observaciones;
    }

    public function getActaNumero() {
        return $this->ActaNumero;
    }

    public function setActaNumero($ActaNumero) {
        $this->ActaNumero = $ActaNumero;
    }

    public function getProtocoloNumero() {
        return $this->ProtocoloNumero;
    }

    public function setProtocoloNumero($ProtocoloNumero) {
        $this->ProtocoloNumero = $ProtocoloNumero;
    }

    public function getResultado() {
        return $this->Resultado;
    }

    public function setResultado($Resultado) {
        $this->Resultado = $Resultado;
    }


  
}
