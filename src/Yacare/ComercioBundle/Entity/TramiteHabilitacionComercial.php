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
    
    /**
     * @ORM\ManyToOne(targetEntity="Yacare\ComercioBundle\Entity\Comercio")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=false)
     */
    protected $Comercio;
    
    /**
     * @var string
     * @ORM\Column(type="integer", nullable=true)
     * 
     * Almacena un el valor de uso de suelo para la partida en la cual se encuentra el local, para la actividad seleccionada.
     */
    private $UsoSuelo;

    
    public function EstaListoParaTerminar() {
        return $this->getUsoSuelo() <=3 
                && parent::EstaListoParaTerminar();
    }

    
    public function UsoSueloNombre() {
        return \Yacare\CatastroBundle\Entity\UsoSuelo::UsoSueloNombre($this->getUsoSuelo());
    }



    public function getUsoSuelo() {
        return $this->UsoSuelo;
    }

    public function setUsoSuelo($UsoSuelo) {
        $this->UsoSuelo = $UsoSuelo;
    }
    
    public function getComercio() {
        return $this->Comercio;
    }

    public function setComercio($Comercio) {
        $this->Comercio = $Comercio;
    }
}
