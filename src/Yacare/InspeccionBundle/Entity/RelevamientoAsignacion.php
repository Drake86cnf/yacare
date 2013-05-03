<?php

namespace Yacare\InspeccionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\InspeccionBundle\Entity\RelevamientoAsignacion
 *
 * @ORM\Table(name="Inspeccion_RelevamientoAsignacion")
 * @ORM\Entity
 */
class RelevamientoAsignacion
{
    use \Yacare\BaseBundle\Entity\Timestampable;
    use \Yacare\BaseBundle\Entity\Versionable;

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
     * @ORM\ManyToOne(targetEntity="Yacare\RecursosHumanosBundle\Entity\Agente")
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
     * Get id
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    
    public function getNombre() {
        if($this->getCalle()) {
            $this->Nombre = $this->Calle->getNombre() . '  ' . $this->getEncargado()->getPersona()->getNombreVisible();
        } else {
            $this->Nombre = 'Sección ' . $this->getSeccion() . ', macizo ' . $this->getMacizo() . ' a ' . $this->getEncargado()->getPersona()->getNombreVisible();
        }
        
        return $this->Nombre;
    }

    public function setNombre($Nombre) {
        if($this->getCalle()) {
            $this->Nombre = $this->Calle->getNombre() . '  ' . $this->getEncargado()->getPersona()->getNombreVisible();
        } else {
            $this->Nombre = 'Sección ' . $this->getSeccion() . ', macizo ' . $this->getMacizo() . ' a ' . $this->getEncargado()->getPersona()->getNombreVisible();
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
        $this->Seccion = $Seccion;
    }

    public function getMacizo() {
        return $this->Macizo;
    }

    public function setMacizo($Macizo) {
        $this->Macizo = $Macizo;
    }
}
