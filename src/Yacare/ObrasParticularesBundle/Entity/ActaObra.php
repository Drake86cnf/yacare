<?php
namespace Yacare\ObrasParticularesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
    //use \Yacare\BaseBundle\Entity\ConAdjuntos;
    use \Yacare\CatastroBundle\Entity\ConPartida;
    use \Yacare\ObrasParticularesBundle\Entity\ConProfesional;

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
    private $TipoConstruccion = '';
    
    /**
     * El estado de avance de la obra.
     *
     * @var integer
     * 
     * @ORM\Column(type="integer", nullable=false)
     */
    private $EstadoAvance = 0;
    
    /**
     * La fecha de descargo del acta.
     *
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     * 
     * @Assert\Expression(
     *     "(this.getFecha() <= this.getFechaDescargo()) || this.getFechaDescargo() === null",
     *     message = "La fecha de descargo no puede ser anterior a la fecha de redacción del acta en cuestión." 
     * )
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
    
    /**
     * Detalles adicionales al momento de emitir un descargo.
     * 
     * @var string
     * 
     * @ORM\Column(type="text", nullable=true)
     */
    private $DescargoDetalle;
    
    
    /**
     * Devuelve la fecha de vencimiento, si hay un plazo de compromiso.
     * 
     * El plazo se considera vencido _después_ de la fecha de vencimiento. O sea, hasta la fecha de vencimiento
     * inclusive el plazo es válido.
     *   
     * @return DateTime|NULL
     */
    public function getFechaVencimiento() {
        if($this->getPlazo() && $this->getFechaDescargo()) {
            $FechaVencimiento = clone $this->getFechaDescargo();
            $FechaVencimiento->add(new \DateInterval('P' . $this->getPlazo() . 'D'));
            $FechaVencimiento->setTime(23, 59, 59);
            return $FechaVencimiento;
        } else {
            // No tiene descargo o no tiene plazo
            return null;
        }
    }
    
    /**
     * Devuelve true si el acta tiene un plazo de compromiso y el plazo venció.
     */
    public function EstaVencida() {
        $FechaVencimiento = $this->getFechaVencimiento();
        if($FechaVencimiento) {
            $Ahora = new \DateTime();
            return $Ahora > $FechaVencimiento;
        } else {
            // No tiene fecha de vencimiento
            return false;
        }
    }

    public function getEstadoAvanceNombre()
    {
        return self::EstadoAvanceNombres($this->getEstadoAvance(), $this->getTipoConstruccion());
    }
    
    public static function EstadoAvanceNombres($rango, $tipoConstruccion)
    {
        switch ($rango) {
            case 1:
                return 'Replanteo y fundaciones';
            case 3:
                return 'Platea';
            case 5:
                if ($tipoConstruccion === 'Seca') {
                    return 'Estructura en planta baja';
                } else {
                    return 'Mampostería en planta baja';
                }
            case 10:
                return 'Encadenado superior en planta baja';
            case 15:
                return 'Entrepiso';
            case 20:
                if ($tipoConstruccion === 'Seca') {
                    return 'Estructura en planta alta';                    
                } else {
                    return 'Mampostería en planta alta';
                }
            case 25:
                return 'Encadenado superior en planta alta';
            case 30:
                return 'Estructura de techo';
            case 35:
                return 'Techado';
            default:
                return 'Ninguno';
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

    /**
     * @ignore
     */
    public function getDescargoDetalle()
    {
        return $this->DescargoDetalle;
    }

    /**
     * @ignore
     */
    public function setDescargoDetalle($DescargoDetalle)
    {
        $this->DescargoDetalle = $DescargoDetalle;
        return $this;
    }
}
