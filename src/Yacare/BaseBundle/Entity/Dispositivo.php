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
    
    /**** Getters y setters ****/
    
    /**
     * @ignore
     */
     public function getNumeroSerie()
    {
        return $this->NumeroSerie;
    }

    /**
     * @ignore
     */
    public function setNumeroSerie($NumeroSerie)
    {
        $this->NumeroSerie = $NumeroSerie;
    }

    /**
     * @ignore
     */
    public function getEncargado()
    {
        return $this->Encargado;
    }

    /**
     * @ignore
     */
    public function setEncargado($Encargado)
    {
        $this->Encargado = $Encargado;
    }

    /**
     * @ignore
     */
    public function getIdentificadorUnico()
    {
        return $this->IdentificadorUnico;
    }

    /**
     * @ignore
     */
    public function setIdentificadorUnico($IdentificadorUnico)
    {
        $this->IdentificadorUnico = $IdentificadorUnico;
    }

    /**
     * @ignore
     */
    public function getMarca()
    {
        return $this->Marca;
    }

    /**
     * @ignore
     */
    public function getModelo()
    {
        return $this->Modelo;
    }

    /**
     * @ignore
     */
    public function getFirmware()
    {
        return $this->Firmware;
    }

    /**
     * @ignore
     */
    public function setMarca($Marca)
    {
        $this->Marca = $Marca;
    }

    /**
     * @ignore
     */
    public function setModelo($Modelo)
    {
        $this->Modelo = $Modelo;
    }

    /**
     * @ignore
     */
    public function setFirmware($Firmware)
    {
        $this->Firmware = $Firmware;
    }
}
