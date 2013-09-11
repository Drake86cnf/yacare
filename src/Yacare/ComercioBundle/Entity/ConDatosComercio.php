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
     * @ORM\ManyToMany(targetEntity="Yacare\ComercioBundle\Entity\Actividad")
     * @ORM\JoinTable(name="Comercio_Comercio_Actividad")
     */
    protected $ActividadesSecundarias;
    
    
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

    public function getActividadesSecundarias() {
        return $this->ActividadesSecundarias;
    }

    public function setActividadesSecundarias($ActividadesSecundarias) {
        $this->ActividadesSecundarias = $ActividadesSecundarias;
    }
}
