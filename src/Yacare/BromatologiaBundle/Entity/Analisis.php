<?php

namespace Yacare\BromatologiaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\BromatologiaBundle\Entity\Analisis
 *
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Table(name="Bromatologia_Analisis")
 */
class Analisis
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Tapir\BaseBundle\Entity\Versionable;
    use \Tapir\BaseBundle\Entity\Suprimible;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    
    /**
     * @ORM\ManyToOne(targetEntity="Yacare\BromatologiaBundle\Entity\TipoAnalisis")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $TipoAnalisis;
   
    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $Observaciones;
    
    /**
     * @ORM\ManyToOne(targetEntity="Yacare\BromatologiaBundle\Entity\Protocolo")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $ProtocoloNumero;
    
    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $ResultadoAnalisis;
    
    
    
      public function __toString() {
        return $this->getTipoAnalisis()->getNombre();
    }
    
    
        
    public function getTipoAnalisis() {
        return $this->TipoAnalisis;
    }

    public function setTipoAnalisis($TipoAnalisis) {
        $this->TipoAnalisis = $TipoAnalisis;
    }

    public function getObservaciones() {
        return $this->Observaciones;
    }

    public function setObservaciones($Observaciones) {
        $this->Observaciones = $Observaciones;
    }

    public function getProtocoloNumero() {
        return $this->ProtocoloNumero;
    }

    public function setProtocoloNumero($ProtocoloNumero) {
        $this->ProtocoloNumero = $ProtocoloNumero;
    }

    public function getResultadoAnalisis() {
        return $this->ResultadoAnalisis;
    }

    public function setResultadoAnalisis($ResultadoAnalisis) {
        $this->ResultadoAnalisis = $ResultadoAnalisis;
    }  
}
