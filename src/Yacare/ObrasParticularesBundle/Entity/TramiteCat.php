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
    use \Yacare\ComercioBundle\Entity\ConDatosComercio;
    
    /**
     * @var string
     * @ORM\Column(type="integer", nullable=true)
     * 
     * Almacena un el valor de uso de suelo para la partida en la cual se encuentra el local, para la actividad seleccionada.
     */
    private $UsoSuelo;
    
    
    public function UsoSueloNombre() {
        return \Yacare\CatastroBundle\Entity\UsoSuelo::UsoSueloNombre($this->getUsoSuelo());
    }

    
    public function getActividadPrincipal(){
        return $this->ActividadPrincipal;
    }
    
    public function setActividadPrincipal($ActividadPrincipal){
        $this->ActividadPrincipal=$ActividadPrincipal;
    }
    
    public function getActividadSecundaria(){
        return $this->ActividadSecundaria;
    }
    
    public function setActividadSecundaria($ActividadSecundaria){
        $this->ActividadSecundaria=$ActividadSecundaria;
    }
    
    
    public function getActividadTerciaria(){
        return $this->ActividadTerciaria;
    }
    
    public function setActividadTerciaria($ActividadTerciaria){
        $this->ActividadTerciaria=$ActividadTerciaria;
    }
 
    public function getUsoSuelo() {
        return $this->UsoSuelo;
    }

    public function setUsoSuelo($UsoSuelo) {
        $this->UsoSuelo = $UsoSuelo;
    }
}
