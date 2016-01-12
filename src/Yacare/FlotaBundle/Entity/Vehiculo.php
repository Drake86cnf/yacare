<?php
namespace Yacare\FlotaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Un vehículo.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 *
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Table(name="Flota_Vehiculo")
 */
class Vehiculo extends \Yacare\NominaBundle\Entity\Dispositivo
{
    use \Tapir\BaseBundle\Entity\Suprimible;
    
    public function __construct()
    {
        $this->Cargas = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Los cargas de combustible realizadas por este vehículo.
     * 
     * @var Carga
     *
     * @ORM\OneToMany(targetEntity="Carga", mappedBy="Vehiculo")
     */
    private $Cargas;
    
    /**
     * El tipo de combustible que lleva este vehículo.
     *
     * Puede ser "nafta", "nafta-98" (nafta de 98 octanos), "gasoil", "gasoil-3" (diesel grado 3), "gnc". 
     *
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Combustible;
    
    /**
     * El año de patentamiento, llamado "modelo". 
     *
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Range(
     *      min = 1980,
     *      max = 2050,
     *      minMessage = "Por favor proporcione un año válido.",
     *      maxMessage = "Por favor proporcione un año válido."
     * )
     */
    private $Anio;
    
    /**
     * El color del vehículo.
     *
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Color;

    /**
     * Devuelve el nombre del combustible (nromalizado).
     * 
     * @return string
     */
    public function getCombustibleNombre()
    {
        return Vehiculo::CombustibleNombres($this->getCombustible());
    }

    /**
     * Devuelve el nombre de un combustible a partir de su código.
     */
    public static function CombustibleNombres($Combustible)
    {
        switch ($Combustible) {
            case null:
                return '';
            case 'nafta':
                return 'Nafta';
            case 'nafta-98':
                return 'Nafta 98 octanos';
            case 'gasoil':
                return 'Gasoil';
            case 'gasoil-3':
                return 'Gasoil grado 3';
            case 'gnc':
                return 'GNC';
            default:
                return '???';
        }
    }

    /**
     * Obtiene la matrícula del vehículo.
     */
    public function getPatente()
    {
        return $this->getNumeroSerie();
    }

    /**
     * Obtiene el código municipal del vehículo.
     */
    public function getCodigo()
    {
        return $this->getIdentificadorUnico();
    }

    public function __toString()
    {
        $res = '';
        
        if($this->getMarca()) {
            $res .= $this->getMarca() . ' ';
        }
        if($this->getModelo()) {
            $res .= $this->getModelo() . ' ';
        }
        
        if($this->getCodigo() || $this->getPatente()) {
            $res .= '(';
            if($this->getCodigo()) {
                $res .= $this->getCodigo() . ' ';
            }
            if($this->getPatente()) {
                $res .= 'mat ' . $this->getPatente() . ' ';
            }
            $res = trim($res) .')';
        }
        
        
        return trim($res);
    }

    /**
     * @ignore
     */
    public function getCargas()
    {
        return $this->Cargas;
    }

    /**
     * @ignore
     */
    public function setCargas($Cargas)
    {
        $this->Cargas = $Cargas;
        return $this;
    }

    /**
     * @ignore
     */
    public function getCombustible()
    {
        return $this->Combustible;
    }

    /**
     * @ignore
     */
    public function setCombustible($Combustible)
    {
        $this->Combustible = $Combustible;
        return $this;
    }

    /**
     * @ignore
     */
    public function getAnio()
    {
        return $this->Anio;
    }

    /**
     * @ignore
     */
    public function setAnio($Anio)
    {
        $this->Anio = $Anio;
        return $this;
    }

    /**
     * @ignore
     */
    public function getColor()
    {
        return $this->Color;
    }

    /**
     * @ignore
     */
    public function setColor($Color)
    {
        $this->Color = $Color;
        return $this;
    }
}
