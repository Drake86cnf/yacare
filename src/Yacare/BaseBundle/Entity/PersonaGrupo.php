<?php

namespace Yacare\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\BaseBundle\Entity\PersonaGrupo
 *
 * @ORM\Table(name="Base_PersonaGrupo")
 * @ORM\Entity
 */
class PersonaGrupo
{
    use \Yacare\BaseBundle\Entity\Timestampable;
    
    public function __construct()
    {
        $this->Personas = new \Doctrine\Common\Collections\ArrayCollection();
    }      
    
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\id
     * @ORM\GeneratedValue(strategy="AUTO")
     * 
     */
    private $id;
        
    /**
     * @var string $Nombre
     *
     * @ORM\Column(name="Nombre", type="string", length=255)
     */
    private $Nombre;    

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
     * @return Pais
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
     * @ORM\ManyToMany(targetEntity="Persona", mappedBy="Grupos", cascade={"persist"})
     */
    protected $Personas;


    /**
     * @ORM\ManyToOne(targetEntity="Yacare\BaseBundle\Entity\PersonaGrupo")
     * @ORM\JoinColumn(name="Parent", referencedColumnName="id", nullable=true)
     */
    public $Parent;
    
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
    
    public function __toString() {
        return $this->Nombre;
    }
}
