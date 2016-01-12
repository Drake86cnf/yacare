<?php
namespace Yacare\CatastroBundle\Entity;

/**
 * Trait que agrega la capacidad de tener una ubicación asociada y la fecha en la cual se consultó la ubicación
 * por última vez.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
trait ConUbicacion {
    /**
     * Coordenadas de su ubicación.
     *
     * @ORM\Column(type="point", nullable=true)
     */
    protected $Ubicacion;
    
    /**
     * Fecha de la última consulta de ubicación.
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $UbicacionFecha;
    
    /**
     * @ignore
     */
    public function getUbicacion() {
        return $this->Ubicacion;
    }
    
    /**
     * @ignore
     */
    public function setUbicacion($Ubicacion) {
        $this->Ubicacion = $Ubicacion;
        return $this;
    }
    
    /**
     * @ignore
     */
    public function getUbicacionFecha()
    {
        return $this->UbicacionFecha;
    }
    
    /**
     * @ignore
     */
    public function setUbicacionFecha($UbicacionFecha)
    {
        $this->UbicacionFecha = $UbicacionFecha;
        return $this;
    }
}