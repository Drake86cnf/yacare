<?php

namespace Yacare\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ConDomicilio
 *
 */
trait ConDomicilio
{
    /**
     * @var string $DomicilioCalle
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $DomicilioCalle;

    /**
     * @var integer $DomicilioNumero
     * @ORM\Column(type="integer", nullable=true)
     */
    private $DomicilioNumero;

    /**
     * @var integer $DomicilioPiso
     * @ORM\Column(type="integer", nullable=true)
     */
    private $DomicilioPiso;

    /**
     * @var integer $DomicilioPuerta
     * @ORM\Column(type="integer", nullable=true)
     */
    private $DomicilioPuerta;
    
    /**
     * @var integer $DomicilioCodigoPostal
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $DomicilioCodigoPostal;
    
    public function getDomicilio() {
        $res = $this->DomicilioCalle;
        
        if($this->DomicilioNumero)
            $res .= ' Nº ' . $this->DomicilioNumero;
        else
            $res .= ' S/N';
        
        if($this->DomicilioPiso)
            $res .= ', piso ' . $this->DomicilioPiso;
        
        if($this->DomicilioPuerta)
            $res .= ', pta. ' . $this->DomicilioPuerta;

        return $res;
    }
    

    public function getDomicilioCalle() {
        return $this->DomicilioCalle;
    }

    public function setDomicilioCalle($DomicilioCalle) {
        $this->DomicilioCalle = $DomicilioCalle;
    }

    public function getDomicilioNumero() {
        return $this->DomicilioNumero;
    }

    public function setDomicilioNumero($DomicilioNumero) {
        $this->DomicilioNumero = $DomicilioNumero;
    }

    public function getDomicilioPiso() {
        return $this->DomicilioPiso;
    }

    public function setDomicilioPiso($DomicilioPiso) {
        $this->DomicilioPiso = $DomicilioPiso;
    }

    public function getDomicilioPuerta() {
        return $this->DomicilioPuerta;
    }

    public function setDomicilioPuerta($DomicilioPuerta) {
        $this->DomicilioPuerta = $DomicilioPuerta;
    }

    public function getDomicilioCodigoPostal() {
        return $this->DomicilioCodigoPostal;
    }

    public function setDomicilioCodigoPostal($DomicilioCodigoPostal) {
        $this->DomicilioCodigoPostal = $DomicilioCodigoPostal;
    }
}
