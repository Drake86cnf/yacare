<?php

namespace Yacare\ComercioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\ComercioBundle\Entity\TramiteHabilitacionComercial
 *
 * @ORM\Entity
 * @ORM\Table(name="Comercio_TramiteHabilitacionComercial")
 */
class TramiteHabilitacionComercial extends \Yacare\TramitesBundle\Entity\Tramite
{
    use \Yacare\TramitesBundle\Entity\ConApoderado;
    use \Yacare\ComercioBundle\Entity\ConDatosComercio;

    /**
     * @ORM\ManyToMany(targetEntity="Yacare\ComercioBundle\Entity\Actividad")
     * @ORM\JoinTable(name="Comercio_TramiteHabilitacionComercial_Actividad")
     */
    protected $ActividadesSecundarias;
    
    public function __construct()
    {
        $this->ActividadesSecundarias = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    public function getActividadesSecundarias() {
        return $this->ActividadesSecundarias;
    }

    public function setActividadesSecundarias($ActividadesSecundarias) {
        $this->ActividadesSecundarias = $ActividadesSecundarias;
    }
}
