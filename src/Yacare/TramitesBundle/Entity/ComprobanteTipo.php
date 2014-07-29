<?php

namespace Yacare\TramitesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tipo de comprobante.
 * 
 * Define un tipo de comprobante que puede emitirse.
 *
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Table(name="Tramites_ComprobanteTipo")
 */
class ComprobanteTipo
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Tapir\BaseBundle\Entity\ConNombre;
    use \Tapir\BaseBundle\Entity\ConObs;
    use \Tapir\BaseBundle\Entity\Versionable;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;

    /**
     * El código alfanumérico que identifica a este tipo de comprobantes.
     * 
     * @var string
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $Codigo;
    
    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Clase;
    
    /**
     * El período de validez predeterminado para este tipo de comprobantes.
     * 
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $PeriodoValidez;
    
    /**
     * Instrumento espejo.
     * 
     * Al crear o editar un tipo de comprobante, se crea o edita un instrumento
     * que lo refleja.
     * 
     * @ORM\ManyToOne(targetEntity="Instrumento", cascade={ "persist" })
     * @ORM\JoinColumn(nullable=true)
     */
    protected $InstrumentoEspejo;
    
    
    public function getClase() {
        return $this->Clase;
    }

    public function setClase($Clase) {
        $this->Clase = $Clase;
    }
    
    public function getCodigo() {
        return $this->Codigo;
    }

    public function setCodigo($Codigo) {
        $this->Codigo = $Codigo;
    }
    
    public function getInstrumentoEspejo() {
        return $this->InstrumentoEspejo;
    }

    public function setInstrumentoEspejo($InstrumentoEspejo) {
        $this->InstrumentoEspejo = $InstrumentoEspejo;
    }
    
    public function getPeriodoValidez() {
        return $this->PeriodoValidez;
    }

    public function setPeriodoValidez($PeriodoValidez) {
        $this->PeriodoValidez = $PeriodoValidez;
    }
}
