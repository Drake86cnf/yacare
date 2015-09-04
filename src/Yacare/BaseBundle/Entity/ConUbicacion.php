<?php
namespace Yacare\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Agrega la ubicación (punto de latitud y longitud).
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
trait ConUbicacion
{
    /**
     * El punto de la ubicación.
     * 
     * @var integer
     * 
     * @ORM\Column(type="point")
     */
    private $UbicacionPunto = 0;

    /**
     * @ignore
     */
    public function getUbicacionPunto()
    {
        return $this->UbicacionPunto;
    }

    /**
     * @ignore
     */
    public function setUbicacionPunto($UbicacionPunto)
    {
        $this->UbicacionPunto = $UbicacionPunto;
        return $this;
    }
}
