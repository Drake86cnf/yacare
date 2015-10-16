<?php
namespace Yacare\FlotaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Una carga de combustible.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 *
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Table(name="Flota_Carga")
 */
class Carga
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;

    /**
     * El vehículo al cual pertenece esta carga.
     *
     * @var \Yacare\FlotaBundle\Entity\Vehiculo
     *
     * @ORM\ManyToOne(targetEntity="Yacare\FlotaBundle\Entity\Vehiculo")
     */
    protected $Vehiculo;
    
    /**
     * La cantidad de litros.
     *
     * @var int
     *
     * @ORM\Column(type="integer", nullabled=true)
     */
    private $Litros;
    
    /**
     * El importe pagado o correspondiente a la carga.
     *
     * @var float
     *
     * @ORM\Column(type="float", nullabled=true)
     */
    private $Importe;
    
    /**
     * La cantidad de kilómetros del vehículo al momento de la carga.
     *
     * @var int
     *
     * @ORM\Column(type="integer", nullabled=true)
     */
    private $Kilometraje;
    
    /**
     * El tipo de combustible que lleva este vehículo.
     *
     * Puede ser "nafta", "nafta-98" (nafta de 98 octanos), "gasoil", "gasoil-3" (diesel grado 3), "gnc".
     *
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullabled=true)
     */
    private $Combustible;
    

    /**
     * @return the Vehiculo
     */
    public function getVehiculo()
    {
        return $this->Vehiculo;
    }

    /**
     * @param  $Vehiculo
     */
    public function setVehiculo($Vehiculo)
    {
        $this->Vehiculo = $Vehiculo;
        return $this;
    }

    /**
     * @return the int
     */
    public function getLitros()
    {
        return $this->Litros;
    }

    /**
     * @param int $Litros
     */
    public function setLitros($Litros)
    {
        $this->Litros = $Litros;
        return $this;
    }

    /**
     * @return the float
     */
    public function getImporte()
    {
        return $this->Importe;
    }

    /**
     * @param float $Importe
     */
    public function setImporte($Importe)
    {
        $this->Importe = $Importe;
        return $this;
    }

    /**
     * @return the int
     */
    public function getKilometraje()
    {
        return $this->Kilometraje;
    }

    /**
     * @param int $Kilometraje
     */
    public function setKilometraje($Kilometraje)
    {
        $this->Kilometraje = $Kilometraje;
        return $this;
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
}
