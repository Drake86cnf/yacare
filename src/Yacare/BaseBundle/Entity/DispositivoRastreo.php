<?php
namespace Yacare\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * El rastreo asociado de un dispositivo GPS.
 *
 * @author Ezequiel Riquelme <rezequiel.tdf@gmail.com>
 * 
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Table(name="Base_DispositivoRastreo")
 */
class DispositivoRastreo
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    
    /**
     * Coordenadas de su ubicación.
     * 
     * @var \Point
     * 
     * @ORM\Column(type="point")
     */
    protected $Ubicacion;
    
    /**
     * La velocidad.
     * 
     * @var integer
     * 
     * @ORM\Column(type="integer")
     */
    protected $Velocidad;
    
    /**
     * El rumbo.
     * 
     * @var integer
     * 
     * @ORM\Column(type="integer")
     */
    protected $Rumbo;
    
    /**
     * El dispositivo asociado.
     * 
     * @var DispositivoRastreadorGps
     * 
     * @ORM\ManyToOne(targetEntity="\Yacare\BaseBundle\Entity\DispositivoRastreadorGps")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $Dispositivo;

    /*** Getters y Setters ****/
    
    /**
     * @ignore
     */
    public function getVelocidad()
    {
        return $this->Velocidad;
    }

    /**
     * @ignore
     */
    public function setVelocidad($Velocidad)
    {
        $this->Velocidad = $Velocidad;
    }

    /**
     * @ignore
     */
    public function getRumbo()
    {
        return $this->Rumbo;
    }

    /**
     * @ignore
     */
    public function setRumbo($Rumbo)
    {
        $this->Rumbo = $Rumbo;
    }

    /**
     * @ignore
     */
    public function getDispositivo()
    {
        return $this->Dispositivo;
    }

    /**
     * @ignore
     */
    public function setDispositivo($Dispositivo)
    {
        $this->Dispositivo = $Dispositivo;
    }

    /**
     * @ignore
     */
    public function getUbicacion()
    {
        return $this->Ubicacion;
    }

    /**
     * @ignore
     */
    public function setUbicacion($Ubicacion)
    {
        $this->Ubicacion = $Ubicacion;
        return $this;
    }
}
