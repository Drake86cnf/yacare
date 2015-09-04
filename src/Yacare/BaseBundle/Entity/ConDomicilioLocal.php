<?php
namespace Yacare\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Agrega datos de domicilio local a una entidad.
 *
 * Los domicilios locales, a diferencia de los comunes, están asociados a una
 * calle por su ID y no por su nombre.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
trait ConDomicilioLocal
{
    /**
     * Relación con la tabla de calles.
     *
     * @see \Yacare\CatastroBundle\Entity\Calle YacareCatastroBundle:Calle 
     * 
     * @ORM\ManyToOne(targetEntity="\Yacare\CatastroBundle\Entity\Calle")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $DomicilioCalle;
    
    /**
     * El número, también conocido como "altura".
     *
     * @var integer
     * 
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $DomicilioNumero;
    
    /**
     * El piso, si lo hubiera.
     *
     * @var integer
     * 
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $DomicilioPiso;
    
    /**
     * La puerta, si la hubiera (por ejemplo A, B, etc.)
     *
     * @var integer
     * 
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $DomicilioPuerta;

    /**
     * Devuelve el nombre completo del domicilio del local.
     * 
     * @return string
     */
    public function getDomicilio()
    {
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
}
