<?php

namespace Yacare\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Agrega datos de domicilio local a una entidad.
 * 
 * Los domicilios locales, a diferencia de los comunes, están asociados a una
 * calle por su ID y no por su nombre.
 *
 * @author Ernesto Carrea <equistango@gmail.com>
 */
trait ConDomicilioLocal
{
    /**
     * Relación con la tabla de calles.
     * 
     * @see \Yacare\CatastroBundle\Entity\Calle
     * 
     * @ORM\ManyToOne(targetEntity="\Yacare\CatastroBundle\Entity\Calle")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $DomicilioCalle;

    /**
     * El número, también conocido como "altura".
     * 
     * @var integer $DomicilioNumero
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $DomicilioNumero;

    /**
     * El piso, si lo hubiera.
     * 
     * @var integer $DomicilioPiso
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $DomicilioPiso;

    /**
     * La puerta, si la hubiera (por ejemplo A, B, etc.)
     * 
     * @var integer $DomicilioPuerta
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $DomicilioPuerta;
    

    public function getDomicilio() {
        $res = $this->DomicilioCalle;
        
        if ($this->DomicilioNumero)
            $res .= ' Nº ' . $this->DomicilioNumero;
        else
            $res .= ' S/N';
        
        if ($this->DomicilioPiso)
            $res .= ', piso ' . $this->DomicilioPiso;
        
        if ($this->DomicilioPuerta)
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
