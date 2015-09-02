<?php
namespace Yacare\InspeccionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Talonario de actas.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 * 
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Table(name="Inspeccion_ActaTalonario")
 */
class ActaTalonario
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Tapir\BaseBundle\Entity\ConNombre;
    use \Tapir\BaseBundle\Entity\Versionable;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    
    /**
     * @var ActaTipo
     * 
     * @ORM\ManyToOne(targetEntity="Yacare\InspeccionBundle\Entity\ActaTipo")
     */
    protected $Tipo;
    
    /**
     * @var int
     * 
     * @ORM\Column(type="integer")
     */
    private $NumeroDesde;
    
    /**
     * @var int
     * 
     * @ORM\Column(type="integer")
     */
    private $NumeroHasta;
    
    /**
     * @var \Yacare\BaseBundle\Entity\Persona
     * 
     * @ORM\ManyToOne(targetEntity="Yacare\BaseBundle\Entity\Persona")
     * @ORM\JoinColumn(nullable=true)
     * @ORM\OrderBy({ "NombreVisible" = "ASC" })
     */
    protected $EnPoderDe;

    /**
     * Establece el nombre a mostrar.
     */
    private function ConstruirNombre()
    {
        $this->Nombre = $this->Tipo . ' Nº del ' . $this->NumeroDesde . ' al ' . $this->NumeroHasta;
    }

    /**
     * @ignore
     */
    public function getTipo()
    {
        return $this->Tipo;
    }

    /**
     * @ignore
     */
    public function setTipo($Tipo)
    {
        $this->Tipo = $Tipo;
    }

    /**
     * @ignore
     */
    public function setNumeroDesde($NumeroDesde)
    {
        $this->NumeroDesde = $NumeroDesde;
        $this->ConstruirNombre();
    }

    /**
     * @ignore
     */
    public function setNumeroHasta($NumeroHasta)
    {
        $this->NumeroHasta = $NumeroHasta;
        $this->ConstruirNombre();
    }

    /**
     * @ignore
     */
    public function getEnPoderDe()
    {
        return $this->EnPoderDe;
    }

    /**
     * @ignore
     */
    public function setEnPoderDe($EnPoderDe)
    {
        $this->EnPoderDe = $EnPoderDe;
    }

    /**
     * @ignore
     */
    public function getNumeroDesde()
    {
        return $this->NumeroDesde;
    }

    /**
     * @ignore
     */
    public function getNumeroHasta()
    {
        return $this->NumeroHasta;
    }
}
