<?php

namespace Yacare\ComercioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

trait ConDatosComercio {
    /**
     * @ORM\ManyToOne(targetEntity="Yacare\ComercioBundle\Entity\Local")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $Local;
    
    /**
     * @ORM\ManyToOne(targetEntity="Yacare\ComercioBundle\Entity\Actividad")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $ActividadPrincipal;
    
    /**
     * @ORM\ManyToOne(targetEntity="Yacare\ComercioBundle\Entity\Actividad")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $ActividadSecundaria;
    
    /**
     * @ORM\ManyToOne(targetEntity="Yacare\ComercioBundle\Entity\Actividad")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $ActividadTerciaria;
    
    
    public function getLocal() {
        return $this->Local;
    }

    public function setLocal($Local) {
        $this->Local = $Local;
    }

    public function getActividadPrincipal() {
        return $this->ActividadPrincipal;
    }

    public function setActividadPrincipal($ActividadPrincipal) {
        $this->ActividadPrincipal = $ActividadPrincipal;
    }
    
    public function getActividadSecundaria() {
        return $this->ActividadSecundaria;
    }

    public function getActividadTerciaria() {
        return $this->ActividadTerciaria;
    }

    public function setActividadSecundaria($ActividadSecundaria) {
        $this->ActividadSecundaria = $ActividadSecundaria;
    }

    public function setActividadTerciaria($ActividadTerciaria) {
        $this->ActividadTerciaria = $ActividadTerciaria;
    }
}
