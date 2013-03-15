<?php

namespace Yacare\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\BaseBundle\Entity\Edificio
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Edificio
{
    /**
     * @ORM\OneToMany(targetEntity="Oficina", mappedBy="Edificio")
     */
    private $Oficinas;
    
    public function __construct()
    {
        $this->Oficinas = new ORM\ArrayCollection();
    }
    
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    
    
    /**
     * @var string $Nombre
     *
     * @ORM\Column(name="Nombre", type="string", length=255)
     */
    private $Nombre;

    /**
     * @var string $Domicilio
     *
     * @ORM\Column(name="Domicilio", type="string", length=255)
     */
    private $Domicilio;

    /**
     * @var integer $Telefono
     *
     * @ORM\Column(name="Telefono", type="integer")
     */
    private $Telefono;


    /**
     * Set Nombre
     *
     * @param string $nombre
     * @return Edificio
     */
    public function setNombre($nombre)
    {
        $this->Nombre = $nombre;
    
        return $this;
    }

    /**
     * Get Nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->Nombre;
    }

    /**
     * Set Domicilio
     *
     * @param string $domicilio
     * @return Edificio
     */
    public function setDomicilio($domicilio)
    {
        $this->Domicilio = $domicilio;
    
        return $this;
    }

    /**
     * Get Domicilio
     *
     * @return string 
     */
    public function getDomicilio()
    {
        return $this->Domicilio;
    }

    /**
     * Set Telefono
     *
     * @param integer $telefono
     * @return Edificio
     */
    public function setTelefono($telefono)
    {
        $this->Telefono = $telefono;
    
        return $this;
    }

    /**
     * Get Telefono
     *
     * @return integer 
     */
    public function getTelefono()
    {
        return $this->Telefono;
    }
}
