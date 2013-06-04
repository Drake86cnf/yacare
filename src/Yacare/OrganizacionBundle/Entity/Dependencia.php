<?php

namespace Yacare\OrganizacionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\OrganizacionBundle\Entity\Dependencia
 *
 * @ORM\Table(name="Organizacion_Dependencia")
 * @ORM\Entity
 */
class Dependencia
{
    use \Yacare\BaseBundle\Entity\Timestampable;
    use \Yacare\BaseBundle\Entity\Versionable;

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
     * @ORM\ManyToOne(targetEntity="Yacare\OrganizacionBundle\Entity\Dependencia")
     * @ORM\JoinColumn(name="Parent", referencedColumnName="id", nullable=true)
     */
    private $Parent;

    public function getId()
    {
        return $this->id;
    }

    public function getOficinas() {
        return $this->Oficinas;
    }

    public function setOficinas($Oficinas) {
        $this->Oficinas = $Oficinas;
    }

    public function getNombre() {
        return $this->Nombre;
    }

    public function setNombre($Nombre) {
        $this->Nombre = $Nombre;
    }

    public function getParent() {
        return $this->Parent;
    }

    public function setParent($Parent) {
        $this->Parent = $Parent;
    }
}
