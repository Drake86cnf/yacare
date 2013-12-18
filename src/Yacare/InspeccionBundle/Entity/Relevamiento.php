<?php

namespace Yacare\InspeccionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Relevamiento
 *
 * @ORM\Table("Inspeccion_Relevamiento")
 * @ORM\Entity(repositoryClass="Yacare\BaseBundle\Entity\YacareBaseRepository")
 */
class Relevamiento
{
    use \Yacare\BaseBundle\Entity\ConId;
    use \Yacare\BaseBundle\Entity\ConNombre;
    use \Yacare\BaseBundle\Entity\Versionable;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    
    public function __construct()
    {
        $this->Asignaciones = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    
    /**
     * @ORM\OneToMany(targetEntity="RelevamientoAsignacion", mappedBy="Relevamiento")
     */
    private $Asignaciones;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $FechaInicio;

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
}
