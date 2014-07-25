<?php

namespace Yacare\InspeccionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\InspeccionBundle\Entity\RelevamientoAsignacion
 *
 * @ORM\Table(name="Inspeccion_RelevamientoAsignacion")
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\HasLifecycleCallbacks
 */
class RelevamientoAsignacion
{
    /*
    UPDATE Inspeccion_RelevamientoAsignacionResultado SET Asignacion_id=(SELECT Asignacion_id FROM Inspeccion_RelevamientoAsignacionDetalle WHERE Inspeccion_RelevamientoAsignacionResultado.Detalle_id=Inspeccion_RelevamientoAsignacionDetalle.id);
    UPDATE Inspeccion_RelevamientoAsignacion SET DetallesCantidad=(SELECT COUNT(id) FROM Inspeccion_RelevamientoAsignacionDetalle WHERE Asignacion_id=Inspeccion_RelevamientoAsignacion.id);
    UPDATE Inspeccion_RelevamientoAsignacion SET DetallesResultadosCantidad=(SELECT COUNT(DISTINCT Detalle_id) FROM Inspeccion_RelevamientoAsignacionResultado WHERE Inspeccion_RelevamientoAsignacionResultado.Detalle_id IN (SELECT id FROM Inspeccion_RelevamientoAsignacionDetalle WHERE Inspeccion_RelevamientoAsignacionDetalle.Asignacion_id=Inspeccion_RelevamientoAsignacion.id));
    */

    use \Tapir\BaseBundle\Entity\ConId;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    use \Tapir\BaseBundle\Entity\Versionable;
    use \Tapir\BaseBundle\Entity\Suprimible;
    use \Tapir\BaseBundle\Entity\Archivable;


    /**
     * @var string $Nombre
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $Seccion;
    
    /**
     * @var string $Macizo
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $Macizo;
    
    /**
     * @ORM\OneToMany(targetEntity="RelevamientoAsignacionDetalle", mappedBy="Asignacion", cascade={"remove"})
     */
    protected $Detalles;
    
    /**
     * @var string
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $DetallesCantidad = 0;
    
    /**
     * @var string
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
    {
        
    }

    
    public function __toString()
    {
        return $this->getNombre();
    }
    
    
    public function getNombre() {
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

    public function setNombre($Nombre) {
        $this->Nombre = $this->getEncargado()->getNombreVisible();
        if ($this->getCalle()) {
            $this->Nombre .= ': calle ' . $this->Calle->getNombre();
        } else {
            $this->Nombre .= ': sección ' . $this->getSeccion() . ', macizo ' . $this->getMacizo();
        }
    }
    
    public function getRelevamiento() {
        return $this->Relevamiento;
    }

    public function setRelevamiento($Relevamiento) {
        $this->Relevamiento = $Relevamiento;
    }

    public function getEncargado() {
        return $this->Encargado;
    }

    public function setEncargado($Encargado) {
        $this->Encargado = $Encargado;
    }
    public function getCalle() {
        return $this->Calle;
    }

    public function setCalle($Calle) {
        $this->Calle = $Calle;
    }

    public function getSeccion() {
        return $this->Seccion;
    }

    public function setSeccion($Seccion) {
        $this->Seccion = strtoupper($Seccion);
    }

    public function getMacizo() {
        return $this->Macizo;
    }

    public function setMacizo($Macizo) {
        $this->Macizo = strtoupper($Macizo);
    }
    public function getDetalles() {
        return $this->Detalles;
    }

    public function setDetalles($Detalles) {
        $this->Detalles = $Detalles;
    }
    
    public function getDetallesCantidad() {
        return $this->DetallesCantidad;
    }

    public function setDetallesCantidad($DetallesCantidad) {
        $this->DetallesCantidad = $DetallesCantidad;
    }

    public function getDetallesResultadosCantidad() {
        return $this->DetallesResultadosCantidad;
    }

    public function setDetallesResultadosCantidad($DetallesResultadosCantidad) {
        $this->DetallesResultadosCantidad = $DetallesResultadosCantidad;
    }
}
