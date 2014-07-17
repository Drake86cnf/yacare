<?php

namespace Yacare\ObrasParticularesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\ObrasParticularesBundle\Entity\TramiteCat
 *
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Table(name="ObrasParticulares_TramiteCat")
 */
class TramiteCat extends \Yacare\TramitesBundle\Entity\Tramite
{
    use \Yacare\ExpedientesBundle\Entity\ConExpediente;
    use \Yacare\ComercioBundle\Entity\ConActividades;
    
    /**
     * @ORM\ManyToOne(targetEntity="Yacare\CatastroBundle\Entity\Partida")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=false)
     */
    protected $Partida;
    
    
    /**
     * @var string
     * @ORM\Column(type="integer", nullable=true)
     * 
     * Almacena un el valor de uso de suelo para la partida en la cual se encuentra el local, para la actividad seleccionada.
     */
    private $UsoSuelo;
    
    /**
     * @var float
     * @ORM\Column(type="float")
     */
    private $Superficie;
    
    
    public function UsoSueloNombre() {
        return \Yacare\CatastroBundle\Entity\UsoSuelo::UsoSueloNombre($this->getUsoSuelo());
    }


    public function getPartida() {
        return $this->Partida;
    }

    public function setPartida($Partida) {
        $this->Partida = $Partida;
    }
    
    public function getUsoSuelo() {
        return $this->UsoSuelo;
    }

    public function setUsoSuelo($UsoSuelo) {
        $this->UsoSuelo = $UsoSuelo;
    }
    
    public function getSuperficie() {
        return $this->Superficie;
    }

    public function setSuperficie($Superficie) {
        $this->Superficie = $Superficie;
    }
}
