<?php

namespace Yacare\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\BaseBundle\Entity\Dispositivo
 *
 * @ORM\Table(name="Base_Dispositivo")
 * @ORM\Entity(repositoryClass="Yacare\BaseBundle\Entity\YacareBaseRepository")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="Tipo", type="string")
 * @ORM\DiscriminatorMap({
 *      "Cámara" = "\Yacare\SeguridadBundle\Entity\Camara"
 * })
 */
class Dispositivo
{
    use \Yacare\BaseBundle\Entity\ConId;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    use \Yacare\BaseBundle\Entity\Versionable;
    
    /**
     * @var string $Marca
     * @ORM\Column(type="string", length=255)
     */
    protected $Marca;

    /**
     * @var string $Modelo
     * @ORM\Column(type="string", length=255)
     */
    protected $Modelo;
    
    /**
     * @var string $NumeroSerie
     * @ORM\Column(type="string", length=255)
     */
    protected $NumeroSerie;
    
    /**
     * @var string $IdentificadorUnico
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $IdentificadorUnico;
    
    /**
     * @var string $Comentario
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
    
    
    public function __toString()
    {
        return trim(($this->getTipo() == 'Otro' ? '' : $this->getTipo()) . ' ' . $this->getMarca() . ' ' . $this->getModelo() . ' (serie ' . $this->getNumeroSerie() . ')');
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
