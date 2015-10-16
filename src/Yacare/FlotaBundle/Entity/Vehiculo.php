<?php
namespace Yacare\FlotaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Un vehículo.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 *
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Table(name="Flota_Vehiculo")
 */
class Vehiculo extends \Yacare\BaseBundle\Entity\Dispositivo
{
    public function __construct()
    {
        $this->Cargas = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Los cargas de combustible realizadas por este vehículo.
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
    
    public function getCombustibleNombre() {
        return Vehiculo::CombustibleNombres($this->getCombustible());
    }
    
    
    /**
     * Devuelve el nombre de un combustible a partir de su código.
     */
    public static function CombustibleNombres($combustible) {
        switch($combustible) {
            case null: return '';
            case 'nafta': return 'Nafta';
            case 'nafta-98': return 'Nafta 98 octanos';
            case 'gasoil': return 'Gasoil';
            case 'gasoil-3': return 'Gasoil grado 3';
            default: return '???';
        }
    }
    
    /**
     * Obtiene la matrícula del vehículo.
     */
    public function getMatricula() {
        return $this->getNumeroSerie();
    }
    
    /**
     * Obtiene el código municipal del vehículo.
     */
    public function getCodigo() {
        return $this->getIdentificadorUnico();
    }
    
    public function __toString()
    {
        return trim($this->getMarca() . ' ' . $this->getModelo() . ' (' . $this->getCodigo() . ', mat. ' . $this->getMatricula() . ')');
    }
    

    /**
     * @return the string
     */
    public function getCombustible()
    {
        return $this->Combustible;
    }

    /**
     * @param string $Combustible
     */
    public function setCombustible($Combustible)
    {
        $this->Combustible = $Combustible;
        return $this;
    }

    /**
     * @return the int
     */
    public function getAnio()
    {
        return $this->Anio;
    }

    /**
     * @param int $Anio
     */
    public function setAnio($Anio)
    {
        $this->Anio = $Anio;
        return $this;
    }

    /**
     * @return the string
     */
    public function getColor()
    {
        return $this->Color;
    }

    /**
     * @param string $Color
     */
    public function setColor($Color)
    {
        $this->Color = $Color;
        return $this;
    }

    /**
     * @return the unknown_type
     */
    public function getCargas()
    {
        return $this->Cargas;
    }

    /**
     * @param unknown_type $Cargas
     */
    public function setCargas($Cargas)
    {
        $this->Cargas = $Cargas;
        return $this;
    }
}
