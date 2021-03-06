<?php
namespace Yacare\InspeccionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Relevamiento.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 * 
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Table("Inspeccion_Relevamiento")
 */
class Relevamiento
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Tapir\BaseBundle\Entity\ConNombre;
    use \Tapir\BaseBundle\Entity\Versionable;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    use \Tapir\BaseBundle\Entity\Suprimible;

    public function __construct()
    {
        $this->Asignaciones = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * @var RelevamientoAsignacion
     * 
     * @ORM\OneToMany(targetEntity="RelevamientoAsignacion", mappedBy="Relevamiento")
     */
    private $Asignaciones;
    
    /**
     * @var \DateTime 
     * 
     * @ORM\Column(type="datetime")
     */
    private $FechaInicio;

    /**
     * @ignore
     */
    public function getFechaInicio()
    {
        return $this->FechaInicio;
    }

    /**
     * @ignore
     */
    public function setFechaInicio(\DateTime $fechaInicio)
    {
        $this->FechaInicio = $fechaInicio;
    }

    /**
     * @ignore
     */
    public function getAsignaciones()
    {
        return $this->Asignaciones;
    }

    /**
     * @ignore
     */
    public function setAsignaciones($Asignaciones)
    {
        $this->Asignaciones = $Asignaciones;
    }
}
