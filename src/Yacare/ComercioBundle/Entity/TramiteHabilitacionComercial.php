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
     * @var string
     * @ORM\Column(type="integer")
     * 
     * Almacena un el valor de uso de suelo para la partida en la cual se encuentra el local, para la actividad seleccionada.
     */
    private $UsoSuelo;

    
    public function EstaListoParaTerminar() {
        return $this->getUsoSuelo() >= 1 
                && $this->getUsoSuelo() <=3 
                && parent::EstaListoParaTerminar();
    }

    public function setTitular($Titular) {
        $this->setNombre('Habilitación comercial de ' . (string)$Titular);
        parent::setTitular($Titular);
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
}
