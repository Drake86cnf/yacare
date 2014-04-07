<?php

namespace Yacare\SeguridadBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\SeguridadBundle\Entity\Camara
 *
 * @ORM\Table(name="Seguridad_Camara")
 * @ORM\Entity(repositoryClass="Yacare\BaseBundle\Entity\YacareBaseRepository")
 */
class Camara extends \Yacare\BaseBundle\Entity\Dispositivo
{
    /**     
     * @ORM\Column(type="string", length=255)
     */
    private $CamaraTipo;
    
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Ubicacion;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $CoordenadasGps;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $LoginUsuario;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $LoginContrasena;
    
      
    public function getCamaraTipo() {
        return $this->CamaraTipo;
    }

    public function getUbicacion() {
        return $this->Ubicacion;
    }

    public function getCoordenadasGps() {
        return $this->CoordenadasGps;
    }

    public function setCamaraTipo($CamaraTipo) {
        $this->CamaraTipo = $CamaraTipo;
    }

    public function setUbicacion($Ubicacion) {
        $this->Ubicacion = $Ubicacion;
    }

    public function setCoordenadasGps($CoordenadasGps) {
        $this->CoordenadasGps = $CoordenadasGps;
    }

    public function getLoginUsuario() {
        return $this->LoginUsuario;
    }

    public function getLoginContrasena() {
        return $this->LoginContrasena;
    }

    public function setLoginUsuario($LoginUsuario) {
        $this->LoginUsuario = $LoginUsuario;
    }

    public function setLoginContrasena($LoginContrasena) {
        $this->LoginContrasena = $LoginContrasena;
    }
    
}