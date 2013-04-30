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
     * @ORM\Column(name="Nombre", type="string", length=255)
     */
    private $Nombre;

    /**
     * @ORM\ManyToOne(targetEntity="Yacare\BaseBundle\Entity\Dependencia")
     * @ORM\JoinColumn(name="Parent", referencedColumnName="id", nullable=true)
     */
    private $Parent;

    public function getId()
    {
        return $this->id;
    }

    public function setNombre($nombre)
    {
        $this->Nombre = $nombre;
    }

    public function getNombre()
    {
        return $this->Nombre;
    }

    public function setParent($parent)
    {
        $this->Parent = $parent;
    }

    public function getParent()
    {
        return $this->Parent;
    }
}
