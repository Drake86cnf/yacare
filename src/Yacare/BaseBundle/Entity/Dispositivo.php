<?php

namespace Yacare\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\BaseBundle\Entity\Dispositivo
 *
 * @ORM\Table(name="Base_Dispositivo")
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="DispositivoTipo", type="string")
 * @ORM\DiscriminatorMap({
 *      "Otro" = "\Yacare\BaseBundle\Entity\DispositivoGenerico",
 *      "Cámara" = "\Yacare\SeguridadBundle\Entity\Camara"
 * })
 */
class Dispositivo
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    use \Tapir\BaseBundle\Entity\Versionable;
    
    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $Marca;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $Modelo;
    
    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $NumeroSerie;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $IdentificadorUnico;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $Comentario;
    
    /**
     * @ORM\ManyToOne(targetEntity="Yacare\BaseBundle\Entity\Persona")
     */
    protected $Encargado;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $Firmware;
    
    
    public function getDispositivoTipo() {
        return get_class($this);
    }
    
    public function __toString()
    {
        return trim($this->getMarca() . ' ' . $this->getModelo() . ' (serie ' . $this->getNumeroSerie() . ')');
    }
    


    public function getNumeroSerie() {
        return $this->NumeroSerie;
    }

    public function setNumeroSerie($NumeroSerie) {
        $this->NumeroSerie = $NumeroSerie;
    }

    public function getComentario() {
        return $this->Comentario;
    }

    public function setComentario($Comentario) {
        $this->Comentario = $Comentario;
    }

    public function getEncargado() {
        return $this->Encargado;
    }

    public function setEncargado($Encargado) {
        $this->Encargado = $Encargado;
    }

    public function getIdentificadorUnico() {
        return $this->IdentificadorUnico;
    }

    public function setIdentificadorUnico($IdentificadorUnico) {
        $this->IdentificadorUnico = $IdentificadorUnico;
    }
    
    public function getMarca() {
        return $this->Marca;
    }

    public function getModelo() {
        return $this->Modelo;
    }

    public function getFirmware() {
        return $this->Firmware;
    }

    public function setMarca($Marca) {
        $this->Marca = $Marca;
    }

    public function setModelo($Modelo) {
        $this->Modelo = $Modelo;
    }

    public function setFirmware($Firmware) {
        $this->Firmware = $Firmware;
    }
}