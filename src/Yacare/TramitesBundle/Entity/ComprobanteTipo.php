<?php

namespace Yacare\TramitesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\TramitesBundle\Entity\ComprobanteTipo
 *
 * @ORM\Entity(repositoryClass="Yacare\BaseBundle\Entity\YacareBaseRepository")
 * @ORM\Table(name="Tramites_ComprobanteTipo")
 */
class ComprobanteTipo
{
    use \Yacare\BaseBundle\Entity\ConId;
    use \Yacare\BaseBundle\Entity\ConNombre;
    use \Yacare\BaseBundle\Entity\ConObs;
    use \Yacare\BaseBundle\Entity\Versionable;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;

    /**
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
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $PeriodoValidez;
    
    /**
     * Al crear o editar un tipo de comprobante, se crea o edita un instrumento que lo refleja.
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
