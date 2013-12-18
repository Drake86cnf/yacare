<?php

namespace Yacare\InspeccionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\InspeccionBundle\Entity\ActaTalonario
 *
 * @ORM\Table(name="Inspeccion_ActaTalonario")
 * @ORM\Entity(repositoryClass="Yacare\BaseBundle\Entity\YacareBaseRepository")
 */
class ActaTalonario
{
    use \Yacare\BaseBundle\Entity\ConId;
    use \Yacare\BaseBundle\Entity\ConNombre;
    use \Yacare\BaseBundle\Entity\Versionable;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
        
    /**
     * @ORM\ManyToOne(targetEntity="Yacare\InspeccionBundle\Entity\ActaTipo")
     */
    protected $Tipo;
    
    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $NumeroDesde;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $NumeroHasta;
    
    /**
     * @ORM\ManyToOne(targetEntity="Yacare\BaseBundle\Entity\Persona")
     * @ORM\JoinColumn(nullable=true)
     * @ORM\OrderBy({ "NombreVisible" = "ASC" })
     */
    protected $EnPoderDe;
    
    
    private function ConstruirNombre() {
        $this->Nombre = $this->Tipo . ' Nº del ' . $this->NumeroDesde . ' al ' . $this->NumeroHasta;
    }
    
    public function getTipo() {
        return $this->Tipo;
    }

    public function setTipo($Tipo) {
        $this->Tipo = $Tipo;
    }

    public function setNumeroDesde($NumeroDesde) {
        $this->NumeroDesde = $NumeroDesde;
        $this->ConstruirNombre();
    }

    public function setNumeroHasta($NumeroHasta) {
        $this->NumeroHasta = $NumeroHasta;
        $this->ConstruirNombre();
    }

    public function getEnPoderDe() {
        return $this->EnPoderDe;
    }

    public function setEnPoderDe($EnPoderDe) {
        $this->EnPoderDe = $EnPoderDe;
    }

    public function getNumeroDesde() {
        return $this->NumeroDesde;
    }

    public function getNumeroHasta() {
        return $this->NumeroHasta;
    }

}
