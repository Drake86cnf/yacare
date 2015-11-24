<?php
namespace Yacare\ObrasParticularesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
    private $TipoObra;
    
    /**
     * El tipo de la construcción.
     * 
     * @var string
     * 
     * @ORM\Column(type="string", nullable=false)
     */
    private $TipoConstruccion;
    
    /**
     * El estado de avance de la obra.
     *
     * @var integer
     * 
     * @ORM\Column(type="integer", nullable=false)
     */
    private $EstadoAvance;
    
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
     * El plazo de cumplimiento, en un descargo.
     * 
     * @var integer
     * 
     * @ORM\Column(type="integer", nullable=true)
     */
    private $Plazo;

    public function getEstadoAvanceNombre()
    {
        return self::EstadoAvanceNombres($this->getEstadoAvance());
    }
    
    public static function EstadoAvanceNombres($rango)
    {
        switch ($rango) {
            case 1:
                return 'Replanteo y fundaciones';
            case 5:
                return 'Mampostería en planta baja';
            case 6:
                return 'Estructura en planta baja';
            case 10:
                return 'Encadenado superior en planta baja';
            case 15:
                return 'Entrepiso';
            case 20:
                return 'Mampostería en planta alta';
            case 25:
                return 'Encadenado superior en planta alta';
            case 30:
                return 'Estructura de techo';
            case 35:
                return 'Techado';
        }
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
    public function getTipoConstruccion()
    {
        return $this->TipoConstruccion;
    }

    /**
     * @ignore
     */
    public function setTipoConstruccion($TipoConstruccion)
    {
        $this->TipoConstruccion = $TipoConstruccion;
        return $this;
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
    public function setEstadoAvance($EstadoAvance)
    {
        $this->EstadoAvance = $EstadoAvance;
        return $this;
    }

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
    public function setFechaDescargo($FechaDescargo)
    {
        $this->FechaDescargo = $FechaDescargo;
        return $this;
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
    public function setPlazo($Plazo)
    {
        $this->Plazo = $Plazo;
        return $this;
    } 
}
