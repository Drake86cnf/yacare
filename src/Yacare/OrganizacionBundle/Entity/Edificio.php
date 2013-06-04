<?php

namespace Yacare\OrganizacionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\OrganizacionBundle\Entity\Edificio
 *
 * @ORM\Table(name="Organizacion_Edificio")
 * @ORM\Entity
 */
class Edificio
{
    use \Yacare\BaseBundle\Entity\Timestampable;
    use \Yacare\BaseBundle\Entity\Versionable;

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

    public function __toString()
    {
        return $this->getNombre();
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

    public function getDomicilio() {
        return $this->Domicilio;
    }

    public function setDomicilio($Domicilio) {
        $this->Domicilio = $Domicilio;
    }

    public function getTelefono() {
        return $this->Telefono;
    }

    public function setTelefono($Telefono) {
        $this->Telefono = $Telefono;
    }
}
