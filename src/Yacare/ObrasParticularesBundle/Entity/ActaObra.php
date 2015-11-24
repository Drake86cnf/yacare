<?php
namespace Yacare\ObrasParticularesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * Representa un acta de inspección, infracción, notificación o compromiso.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 *
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Table(name="ObrasParticulares_ActaObra")
 */
class ActaObra extends \Yacare\InspeccionBundle\Entity\Acta implements IActaObra
{
    use \Yacare\CatastroBundle\Entity\ConPartida;

    public function __construct()
    {
        $this->TipoFaltas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->Nombre = 'Acta de obra nueva';
    }
    
    /**
     * La falta tipificada, o null si no está tipificada.
     *
     * @var \Yacare\ObrasParticularesBundle\Entity\TipoFalta
     *
     * @ORM\ManyToMany(targetEntity="Yacare\ObrasParticularesBundle\Entity\TipoFalta")
     * @ORM\JoinTable(name="ObrasParticulares_ActaObra_TipoFalta")
     */
    protected $TipoFaltas;
    
    /**
     * Tipo de obra.
     *
     * @var integer 
     * 
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $TipoObra;
    
    /**
     * El estado de avance la obra para las actas de obra o 0 para las actas de comercio.
     *
     * @var integer 
     * 
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $EstadoAvance;
    
    /**
     * El plazo para la regularización, si corresponde.
     *
     * Se aplica a todos los subtipos excepto "inspección".
     *
     * @var integer 
     * 
     * @ORM\Column(type="integer")
     */
    protected $Plazo;
    
    /**
     * El profesional a cargo de la obra, en caso que corresponda.
     *
     * Se aplica a todos los subtipos excepto "inspección".
     * 
     * @var \Yacare\ObrasParticularesBundle\Entity\Matriculado
     *
     * @ORM\ManyToOne(targetEntity="Yacare\ObrasParticularesBundle\Entity\Matriculado")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $Profesional;
    
    /**
     * La fecha de descargo del acta.
     *
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $FechaDescargo;

    /**
     * @ignore
     */
    public function getProfesional()
    {
        return $this->Profesional;
    }

    /**
     * @ignore
     */
    public function setProfesional($Profesional)
    {
        $this->Profesional = $Profesional;
    }

    /**
     * @ignore
     */
    public function getComercio()
    {
        return $this->Comercio;
    }

    /**
     * @ignore
     */
    public function setComercio($Comercio)
    {
        $this->Comercio = $Comercio;
    }

    /**
     * @ignore
     */
    public function getEstadoAvance()
    {
        return $this->EstadoAvance;
    }

    /**
     * @ignore
     */
    public function getPlazo()
    {
        return $this->Plazo;
    }

    /**
     * @ignore
     */
    public function setEstadoAvance($EstadoAvance)
    {
        $this->EstadoAvance = $EstadoAvance;
    }

    /**
     * @ignore
     */
    public function setPlazo($Plazo)
    {
        $this->Plazo = $Plazo;
    }

    /**
     * @return the integer
     */
    public function getEstado()
    {
        return $this->Estado;
    }

    /**
     * @param  $Estado
     */
    public function setEstado($Estado)
    {
        $this->Estado = $Estado;
        return $this;
    }

    /**
     * @ignore
     */
    public function getInspector()
    {
        return $this->Inspector;
    }

    /**
     * @ignore
     */
    public function setInspector($Inspector)
    {
        $this->Inspector = $Inspector;
        return $this;
    }

    /**
     * @ignore
     */
    public function getTipoObra()
    {
        return $this->TipoObra;
    }

    /**
     * @ignore
     */
    public function setTipoObra($TipoObra)
    {
        $this->TipoObra = $TipoObra;
        return $this;
    }

    /**
     * @ignore
     */
    public function getTipoFaltas()
    {
        return $this->TipoFaltas;
    }

    /**
     * @ignore
     */
    public function setTipoFaltas($TipoFaltas)
    {
        $this->TipoFaltas = $TipoFaltas;
        return $this;
    }

    /**
     * @ignore
     */
    public function getFechaDescargo()
    {
        return $this->FechaDescargo;
    }

    /**
     * @ignore
     */
    public function setFechaDescargo(\DateTime $FechaDescargo)
    {
        $this->FechaDescargo = $FechaDescargo;
        return $this;
    } 
}
