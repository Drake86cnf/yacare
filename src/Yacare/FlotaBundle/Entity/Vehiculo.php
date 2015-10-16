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
 
}
