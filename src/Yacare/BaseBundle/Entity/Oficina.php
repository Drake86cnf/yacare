<?php

namespace Yacare\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\BaseBundle\Entity\Oficina
 *
 * @ORM\Table(name="Base_Oficina")
 * @ORM\Entity
 */
class Oficina
{
    use \Yacare\BaseBundle\Entity\Timestampable;
    use \Yacare\BaseBundle\Entity\Versionable;
    
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


    public function getId()
    {
        return $this->id;
    }

    public function getNombre() {
        return $this->Nombre;
    }

    public function setNombre($Nombre) {
        $this->Nombre = $Nombre;
    }

    public function getDependencia() {
        return $this->Dependencia;
    }

    public function setDependencia($Dependencia) {
        $this->Dependencia = $Dependencia;
    }

    public function getEdificio() {
        return $this->Edificio;
    }

    public function setEdificio($Edificio) {
        $this->Edificio = $Edificio;
    }

    public function getPrincipal() {
        return $this->Principal;
    }

    public function setPrincipal($Principal) {
        $this->Principal = $Principal;
    }
    
    public function __toString()
    {
        return $this->getNombre();
    }
}
