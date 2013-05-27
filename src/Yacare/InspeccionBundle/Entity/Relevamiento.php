<?php

namespace Yacare\InspeccionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Relevamiento
 *
 * @ORM\Table("Inspeccion_Relevamiento")
 * @ORM\Entity
 */
class Relevamiento
{
    use \Yacare\BaseBundle\Entity\Timestampable;
    use \Yacare\BaseBundle\Entity\Versionable;
    
    public function __construct()
    {
        $this->Asignaciones = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $Nombre;
    
    /**
     * @ORM\OneToMany(targetEntity="RelevamientoAsignacion", mappedBy="Relevamiento")
     */
    private $Asignaciones;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $FechaInicio;


    /**
     * Get id
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    public function getNombre() {
        return $this->Nombre;
    }

    public function setNombre($nombre) {
        $this->Nombre = $nombre;
    }

    public function getFechaInicio() {
        return $this->FechaInicio;
    }

    public function setFechaInicio(\DateTime $fechaInicio) {
        $this->FechaInicio = $fechaInicio;
    }

    public function getAsignaciones() {
        return $this->Asignaciones;
    }

    public function setAsignaciones($Asignaciones) {
        $this->Asignaciones = $Asignaciones;
    }
    
    public function __toString()
    {
        return $this->getNombre();
    }
}
