<?php

namespace Yacare\ObrasParticularesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

 /**
 * Yacare\ObrasParticularesBundle\Entity\Matricula
 *
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Table(name="ObrasParticulares_Matricula")
 * 
 */
 class Matricula
  
{
    use \Tapir\BaseBundle\Entity\ConId;
    
    /**
     * La persona asociada.
     * 
     * @ORM\ManyToOne(targetEntity="Yacare\BaseBundle\Entity\Persona")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=false)
     */
    private $Nombre;
    
    
    
    
    
      /**
     * Indica el estado de la matricula
     * 
     *@var $Estado 
     * @ORM\Column(type="string", nullable=false)
     */
    private $Estado;

    
    
     /**
     * Indica la profesion del matriculado
     * 
     *@var $Profesion 
     * @ORM\Column(type="string", nullable=false)
     */
    private $Profesion;

    
    /**
     * La fecha de vencimiento del pago anual.
     * 
     *@var $FechaVencimiento 
     * @ORM\Column(type="date", nullable=true)
     */
    private $FechaVencimiento;

    /**
     * Email del matriculado.
     * 
     *@var $Email 
     * @ORM\Column(type="string", nullable=true)
     */
    private $Email;


    

    
    public function __toString() {
        return $this->getPersona()->getNombreVisible();
    }
    
    public function getNombre() {
        return $this->Nombre;
    }

    public function setNombre($Nombre) {
        $this->Nombre = $Nombre;
    }
    
    public function getEstado() {
        return $this->Estado;
    }

    public function setEstado($Estado) {
        $this->Estado = $Estado;
    }

    public function getNumeroMatricula() {
        return $this->NumeroMatricula;
    }

    public function setNumeroMatricula($NumeroMatricula) {
        $this->NumeroMatricula = $NumeroMatricula;
    }

    public function getProfesion() {
        return $this->Profesion;
    }

    public function setProfesion($Profesion) {
        $this->Profesion = $Profesion;
    }

    public function getFechaVencimiento() {
        return $this->FechaVencimiento;
    }

    public function setFechaVencimiento($FechaVencimiento = null) {
        $this->FechaVencimiento = $FechaVencimiento;
    }
    

    public function getEmail() {
        return $this->Email;
    }

    public function setEmail($Email) {
        $this->Email = $Email;
    }
}
