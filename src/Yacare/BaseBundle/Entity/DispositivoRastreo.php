<?php
namespace Yacare\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Rastreo asociado a un Rastreador GPS.
 *
 * Yacare\BaseBundle\Entity\DispositivoRastreo
 *
 * @author Ezequiel Riquelme <rezequiel.tdf@gmail.com>
 *        
 *         @ORM\Table(name="Base_DispositivoRastreo")
 *         @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 */
class DispositivoRastreo
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;

    /**
     * @ORM\Column(type="point")
     */
    protected $Ubicacion;

    /**
     * @ORM\Column(type="integer")
     */
    protected $Velocidad;

    /**
     * @ORM\Column(type="integer")
     */
    protected $Rumbo;

    /**
     * @ORM\ManyToOne(targetEntity="\Yacare\BaseBundle\Entity\DispositivoRastreadorGps")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $Dispositivo;

    public function getVelocidad()
    {
        return $this->Velocidad;
    }

    public function setVelocidad($Velocidad)
    {
        $this->Velocidad = $Velocidad;
    }

    public function getRumbo()
    {
        return $this->Rumbo;
    }

    public function setRumbo($Rumbo)
    {
        $this->Rumbo = $Rumbo;
    }

    public function getDispositivo()
    {
        return $this->Dispositivo;
    }

    public function setDispositivo($Dispositivo)
    {
        $this->Dispositivo = $Dispositivo;
    }

    public function getUbicacion()
    {
        return $this->Ubicacion;
    }

    public function setUbicacion($Ubicacion)
    {
        $this->Ubicacion = $Ubicacion;
        return $this;
    }
}