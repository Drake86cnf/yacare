<?php

namespace Yacare\InspeccionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\InspeccionBundle\Entity\RelevamientoAsignacion
 *
 * @ORM\Table(name="Inspeccion_RelevamientoAsignacion")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class RelevamientoAsignacion
{
    use \Yacare\BaseBundle\Entity\Timestampable;
    use \Yacare\BaseBundle\Entity\Versionable;
    use \Yacare\BaseBundle\Entity\Eliminable;

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * 
     */
    private $id;

    /**
     * @var string $Nombre
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Nombre;    
    
    
    /**
     * @ORM\ManyToOne(targetEntity="Relevamiento")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $Relevamiento;
    
    
    /**
     * @ORM\ManyToOne(targetEntity="Yacare\BaseBundle\Entity\Persona")
     * @ORM\JoinColumn(referencedColumnName="id")
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
    

    /**
     * Get id
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    
    public function getNombre() {
        $this->Nombre = $this->getEncargado()->getNombreVisible();
        if($this->getCalle()) {
            $this->Nombre .= ': calle ' . $this->Calle->getNombre();
        } else {
            $this->Nombre .= ': sección ' . $this->getSeccion() . ', macizo ' . $this->getMacizo();
        }
        
        return $this->Nombre;
    }

    public function setNombre($Nombre) {
        $this->Nombre = $this->getEncargado()->getNombreVisible();
        if($this->getCalle()) {
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
    
    public function __toString()
    {
        return $this->getNombre();
    }
}
