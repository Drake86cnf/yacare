<?php

namespace Yacare\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\BaseBundle\Entity\Dependencia
 *
 * @ORM\Table(name="Base_Dependencia")
 * @ORM\Entity
 */
class Dependencia
{
    
    /**
     * @ORM\OneToMany(targetEntity="Oficina", mappedBy="Dependencia")
     */
    private $Oficinas;
    
    public function __construct()
    {
        $this->Oficinas = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @var string $Nombre
     *
     * @ORM\Column(name="Nombre", type="string", length=255)
     */
    private $Nombre;

    /**
     * @ORM\ManyToOne(targetEntity="Yacare\BaseBundle\Entity\Dependencia")
     * @ORM\JoinColumn(name="Parent", referencedColumnName="id", nullable=true)
     */
    private $Parent;

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
     * Set Nombre
     *
     * @param string $nombre
     * @return Dependencia
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
     * Set Parent
     *
     * @param integer $parent
     * @return Dependencia
     */
    public function setParent($parent)
    {
        $this->Parent = $parent;
    
        return $this;
    }

    /**
     * Get Parent
     *
     * @return integer 
     */
    public function getParent()
    {
        return $this->Parent;
    }
}
