<?php
namespace Yacare\InspeccionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Asignación de trabajo para un relevamiento.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 *        
 * @ORM\Table(name="Inspeccion_RelevamientoAsignacion")
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\HasLifecycleCallbacks
 */
class RelevamientoAsignacion
{
    /*
     * UPDATE Inspeccion_RelevamientoAsignacionResultado SET Asignacion_id=(SELECT Asignacion_id FROM
     * Inspeccion_RelevamientoAsignacionDetalle WHERE
     * Inspeccion_RelevamientoAsignacionResultado.Detalle_id=Inspeccion_RelevamientoAsignacionDetalle.id); UPDATE
     * Inspeccion_RelevamientoAsignacion SET DetallesCantidad=(SELECT COUNT(id) FROM
     * Inspeccion_RelevamientoAsignacionDetalle WHERE Asignacion_id=Inspeccion_RelevamientoAsignacion.id); UPDATE
     * Inspeccion_RelevamientoAsignacion SET DetallesResultadosCantidad=(SELECT COUNT(DISTINCT Detalle_id) FROM
     * Inspeccion_RelevamientoAsignacionResultado WHERE Inspeccion_RelevamientoAsignacionResultado.Detalle_id IN (SELECT
     * id FROM Inspeccion_RelevamientoAsignacionDetalle WHERE
     * Inspeccion_RelevamientoAsignacionDetalle.Asignacion_id=Inspeccion_RelevamientoAsignacion.id));
     */
    
    use \Tapir\BaseBundle\Entity\ConId;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    use \Tapir\BaseBundle\Entity\Versionable;
    use \Tapir\BaseBundle\Entity\Suprimible;
    use \Tapir\BaseBundle\Entity\Archivable;
    
    /**
     * @var string $Nombre
     * 
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Nombre;
    
    /**
     * @ORM\ManyToOne(targetEntity="Relevamiento", inversedBy="Asignaciones")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $Relevamiento;
    
    /**
     * @ORM\ManyToOne(targetEntity="Yacare\BaseBundle\Entity\Persona")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=false)
     */
    protected $Encargado;
    
    /**
     * @ORM\ManyToOne(targetEntity="Yacare\CatastroBundle\Entity\Calle")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $Calle;
    
    /**
     * @var string $Seccion
     * 
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $Seccion;
    
    /**
     * @var string $Macizo
     * 
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $Macizo;
    
    /**
     * @ORM\OneToMany(targetEntity="RelevamientoAsignacionDetalle", mappedBy="Asignacion", cascade={"remove"})
     */
    protected $Detalles;
    
    /**
     * @var string 
     * 
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $DetallesCantidad = 0;
    
    /**
     * @var string 
     * 
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $DetallesResultadosCantidad = 0;

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function ActualizarDetalle()
    {
        $this->EliminarDetalle();
    }

    /**
     * @ORM\PreRemove()
     */
    public function EliminarDetalle()
    {}

    public function __toString()
    {
        return $this->getNombre();
    }

    public function getNombre()
    {
        if ($this->getEncargado()) {
            $this->Nombre = $this->getEncargado()->getNombreVisible();
        } else {
            $this->Nombre = 'Sin encargado';
        }
        if ($this->getCalle()) {
            $this->Nombre .= ': calle ' . $this->getCalle()->getNombre();
        } else {
            $this->Nombre .= ': sección ' . $this->getSeccion() . ', macizo ' . $this->getMacizo();
        }
        
        return $this->Nombre;
    }

    public function setNombre($Nombre)
    {
        $this->Nombre = $this->getEncargado()->getNombreVisible();
        if ($this->getCalle()) {
            $this->Nombre .= ': calle ' . $this->Calle->getNombre();
        } else {
            $this->Nombre .= ': sección ' . $this->getSeccion() . ', macizo ' . $this->getMacizo();
        }
    }

    /**
     * @ignore
     */
    public function getRelevamiento()
    {
        return $this->Relevamiento;
    }

    /**
     * @ignore
     */
    public function setRelevamiento($Relevamiento)
    {
        $this->Relevamiento = $Relevamiento;
    }

    /**
     * @ignore
     */
    public function getEncargado()
    {
        return $this->Encargado;
    }

    /**
     * @ignore
     */
    public function setEncargado($Encargado)
    {
        $this->Encargado = $Encargado;
    }

    /**
     * @ignore
     */
    public function getCalle()
    {
        return $this->Calle;
    }

    /**
     * @ignore
     */
    public function setCalle($Calle)
    {
        $this->Calle = $Calle;
    }

    /**
     * @ignore
     */
    public function getSeccion()
    {
        return $this->Seccion;
    }

    /**
     * @ignore
     */
    public function setSeccion($Seccion)
    {
        $this->Seccion = strtoupper($Seccion);
    }

    /**
     * @ignore
     */
    public function getMacizo()
    {
        return $this->Macizo;
    }

    /**
     * @ignore
     */
    public function setMacizo($Macizo)
    {
        $this->Macizo = strtoupper($Macizo);
    }

    /**
     * @ignore
     */
    public function getDetalles()
    {
        return $this->Detalles;
    }

    /**
     * @ignore
     */
    public function setDetalles($Detalles)
    {
        $this->Detalles = $Detalles;
    }

    /**
     * @ignore
     */
    public function getDetallesCantidad()
    {
        return $this->DetallesCantidad;
    }

    /**
     * @ignore
     */
    public function setDetallesCantidad($DetallesCantidad)
    {
        $this->DetallesCantidad = $DetallesCantidad;
    }

    /**
     * @ignore
     */
    public function getDetallesResultadosCantidad()
    {
        return $this->DetallesResultadosCantidad;
    }

    /**
     * @ignore
     */
    public function setDetallesResultadosCantidad($DetallesResultadosCantidad)
    {
        $this->DetallesResultadosCantidad = $DetallesResultadosCantidad;
    }
}
