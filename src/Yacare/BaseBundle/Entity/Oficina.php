<?php

namespace Yacare\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\BaseBundle\Entity\Oficina
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Oficina
{
    use \Yacare\BaseBundle\Entity\Timestampable;
    
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
     * @ORM\ManyToOne(targetEntity="Dependencia", inversedBy="Oficinas")
     */
    protected $Dependencia;
    
    /**
     * @ORM\ManyToOne(targetEntity="Edificio", inversedBy="Oficinas")
     * @ORM\JoinColumn(name="Edificio", referencedColumnName="id")
     */
    protected $Edificio;

    /**
     * @var boolean $Principal
     *
     * @ORM\Column(name="Principal", type="boolean")
     */
    private $Principal;
    
    /**
     * Set Nombre
     *
     * @param string $nombre
     * @return Oficina
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
     * Set Dependencia
     *
     * @param integer $dependencia
     * @return Oficina
     */
    public function setDependencia($dependencia)
    {
        $this->Dependencia = $dependencia;
    
        return $this;
    }

    /**
     * Get Dependencia
     *
     * @return integer 
     */
    public function getDependencia()
    {
        return $this->Dependencia;
    }

    /**
     * Set Edificio
     *
     * @param integer $edificio
     * @return Oficina
     */
    public function setEdificio($edificio)
    {
        $this->Edificio = $edificio;
    
        return $this;
    }

    /**
     * Get Edificio
     *
     * @return integer 
     */
    public function getEdificio()
    {
        return $this->Edificio;
    }

    /**
     * Set Principal
     *
     * @param boolean $principal
     * @return Oficina
     */
    public function setPrincipal($principal)
    {
        $this->Principal = $principal;
    
        return $this;
    }

    /**
     * Get Principal
     *
     * @return boolean 
     */
    public function getPrincipal()
    {
        return $this->Principal;
    }
}
