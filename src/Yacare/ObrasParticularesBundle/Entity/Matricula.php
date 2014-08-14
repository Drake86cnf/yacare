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
    use \Tapir\BaseBundle\Entity\Versionable;
    use \Tapir\BaseBundle\Entity\Suprimible;
    /**
     * La persona asociada.
     * 
     * @ORM\ManyToOne(targetEntity="Yacare\BaseBundle\Entity\Persona")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=false)
     */
    private $Persona;
    
    
    /**
     * @var $Estado
     * @ORM\Column(type="integer", nullable=false)
     */
    private $Estado;
    
    
     /**Indica el numero de matricula municipal.
     * @var $NumeroMatricula
     * @ORM\Column(type="integer", nullable=false)
     */
    private $NumeroMatricula;
    
    /**
     * @var $Profesion
     * @ORM\Column(type="string")
     */
    private $Profesion;
    
    /**
     * La fecha de vencimiento del pago anual.
     * 
     * @ORM\Column(type="date", nullable=true)
     * @Assert\Type("\DateTime")
     */
    private $FechaVencimiento;

    /**
     * @var $Email
     * @ORM\Column(type="string")
     */
    private $Email;

    

    
    public function __toString() {
        return $this->getPersona()->getNombreVisible();
    }
    
    public function getPersona() {
        return $this->Persona;
    }

    public function setPersona($Persona) {
        $this->Persona = $Persona;
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

    public function setFechaVencimiento(\DateTime $FechaVencimiento = null) {
        $this->FechaVencimiento = $FechaVencimiento;
    }
    

    public function getEmail() {
        return $this->Email;
    }

    public function setEmail($Email) {
        $this->Email = $Email;
    }
}
