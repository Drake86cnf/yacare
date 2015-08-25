<?php
namespace Yacare\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Agrega la característica de tener domicilio.
 */
trait ConDomicilio
{
    /**
     * @ORM\ManyToOne(targetEntity="\Yacare\CatastroBundle\Entity\Calle")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $DomicilioCalle;
    
    /**
     * @var string @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $DomicilioCalleNombre;
    
    /**
     * @var integer @ORM\Column(type="integer", nullable=true)
     */
    protected $DomicilioNumero;
    
    /**
     * @var integer @ORM\Column(type="integer", nullable=true)
     */
    protected $DomicilioPiso;
    
    /**
     * @var integer @ORM\Column(type="string", nullable=true)
     */
    protected $DomicilioPuerta;
    
    /**
     * @var integer @ORM\Column(type="string", length=50, nullable=true)
     */
    protected $DomicilioCodigoPostal = '9420';

    public function getDomicilio()
    {
        if ($this->DomicilioCalle) {
            $res = $this->DomicilioCalle;
        } else {
            $res = $this->DomicilioCalleNombre;
        }
        
        if ($this->DomicilioNumero) {
            $res .= ' Nº ' . $this->DomicilioNumero;
        } else {
            $res .= ' S/N';
        }
        
        if ($this->DomicilioPiso) {
            $res .= ', piso ' . $this->DomicilioPiso;
        }
        
        if ($this->DomicilioPuerta) {
            $res .= ', pta. ' . $this->DomicilioPuerta;
        }
        
        return $res;
    }

    /**
     * @ignore
     */
    public function getDomicilioCalle()
    {
        return $this->DomicilioCalle;
    }

    /**
     * @ignore
     */
    public function setDomicilioCalle($DomicilioCalle)
    {
        $this->DomicilioCalle = $DomicilioCalle;
    }

    /**
     * @ignore
     */
    public function getDomicilioCalleNombre()
    {
        return $this->DomicilioCalleNombre;
    }

    /**
     * @ignore
     */
    public function setDomicilioCalleNombre($DomicilioCalleNombre)
    {
        $this->DomicilioCalleNombre = $DomicilioCalleNombre;
    }

    /**
     * @ignore
     */
    public function getDomicilioNumero()
    {
        return $this->DomicilioNumero;
    }

    /**
     * @ignore
     */
    public function setDomicilioNumero($DomicilioNumero)
    {
        $this->DomicilioNumero = $DomicilioNumero;
    }

    /**
     * @ignore
     */
    public function getDomicilioPiso()
    {
        return $this->DomicilioPiso;
    }

    /**
     * @ignore
     */
    public function setDomicilioPiso($DomicilioPiso)
    {
        $this->DomicilioPiso = $DomicilioPiso;
    }

    /**
     * @ignore
     */
    public function getDomicilioPuerta()
    {
        return $this->DomicilioPuerta;
    }

    /**
     * @ignore
     */
    public function setDomicilioPuerta($DomicilioPuerta)
    {
        $this->DomicilioPuerta = $DomicilioPuerta;
    }

    /**
     * @ignore
     */
    public function getDomicilioCodigoPostal()
    {
        return $this->DomicilioCodigoPostal;
    }

    /**
     * @ignore
     */
    public function setDomicilioCodigoPostal($DomicilioCodigoPostal)
    {
        $this->DomicilioCodigoPostal = $DomicilioCodigoPostal;
    }
}
