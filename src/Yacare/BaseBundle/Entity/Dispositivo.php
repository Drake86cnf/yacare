<?php
namespace Yacare\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Clase base para dispositivos.
 *
 * @ORM\Table(name="Base_Dispositivo")
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="DispositivoTipo", type="string")
 * @ORM\DiscriminatorMap({
 *  "Otro" = "\Yacare\BaseBundle\Entity\DispositivoGenerico",
 *  "RastreadorGps" = "\Yacare\BaseBundle\Entity\DispositivoRastreadorGps"
 * })
 */
abstract class Dispositivo
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Tapir\BaseBundle\Entity\ConObs;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    use \Tapir\BaseBundle\Entity\Versionable;

    /**
     * La marca del dispositivo.
     * 
     * @ORM\Column(type="string", length=255)
     */
    protected $Marca;

    /**
     * El modelo del dispositivo.
     * 
     * @ORM\Column(type="string", length=255)
     */
    protected $Modelo;

    /**
     * El número de serie.
     * 
     * @ORM\Column(type="string", length=255)
     */
    protected $NumeroSerie;

    /**
     * Un identificador único (por ejemplo dirección MAC).
     * 
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $IdentificadorUnico;

    /**
     * La persona encargada del dispositivo.
     * 
     * @ORM\ManyToOne(targetEntity="Yacare\BaseBundle\Entity\Persona")
     */
    protected $Encargado;

    /**
     * La versión de firmware.
     * 
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $Firmware;
    

    public function getDispositivoTipo()
    {
        return get_class($this);
    }

    public function __toString()
    {
        return trim($this->getMarca() . ' ' . $this->getModelo() . ' (serie ' . $this->getNumeroSerie() . ')');
    }
    
    // **** Getters y setters

    public function getNumeroSerie()
    {
        return $this->NumeroSerie;
    }

    public function setNumeroSerie($NumeroSerie)
    {
        $this->NumeroSerie = $NumeroSerie;
    }

    public function getEncargado()
    {
        return $this->Encargado;
    }

    public function setEncargado($Encargado)
    {
        $this->Encargado = $Encargado;
    }

    public function getIdentificadorUnico()
    {
        return $this->IdentificadorUnico;
    }

    public function setIdentificadorUnico($IdentificadorUnico)
    {
        $this->IdentificadorUnico = $IdentificadorUnico;
    }

    public function getMarca()
    {
        return $this->Marca;
    }

    public function getModelo()
    {
        return $this->Modelo;
    }

    public function getFirmware()
    {
        return $this->Firmware;
    }

    public function setMarca($Marca)
    {
        $this->Marca = $Marca;
    }

    public function setModelo($Modelo)
    {
        $this->Modelo = $Modelo;
    }

    public function setFirmware($Firmware)
    {
        $this->Firmware = $Firmware;
    }
}