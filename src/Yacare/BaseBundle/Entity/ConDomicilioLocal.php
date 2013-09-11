<?php

namespace Yacare\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ConDomicilioLocal
 *
 */
trait ConDomicilioLocal
{
    /**
     * @ORM\ManyToOne(targetEntity="\Yacare\CatastroBundle\Entity\Calle")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $DomicilioCalle;

    /**
     * @var integer $DomicilioNumero
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $DomicilioNumero;

    /**
     * @var integer $DomicilioPiso
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $DomicilioPiso;

    /**
     * @var integer $DomicilioPuerta
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $DomicilioPuerta;
    

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
}
