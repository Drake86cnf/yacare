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
    private $UsuarioLogin;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ContraseñaLogin;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
       
    
            




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


}
