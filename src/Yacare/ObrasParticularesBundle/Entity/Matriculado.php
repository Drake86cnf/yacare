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
class Matriculado
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Tapir\BaseBundle\Entity\Suprimible;
    use \Tapir\BaseBundle\Entity\Archivable;
    use \Tapir\BaseBundle\Entity\Versionable;
    
    /**
     * La persona asociada.
     * 
     * @ORM\ManyToOne(targetEntity="Yacare\BaseBundle\Entity\Persona")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=false)
     */
    private $Persona;
    
    
    /**
     * Número de matrícula. Temporal.
     * 
     * @var $Numero 
     * @ORM\Column(type="integer", unique=true, nullable=false)
     */
    private $Numero;
    
    
    /**
     * Indica la profesion del matriculado
     * 
     * @var $Profesion 
     * @ORM\Column(type="string", nullable=false)
     */
    private $Profesion;

    /**
     * La fecha de vencimiento del pago anual.
     * 
     * @var $FechaVencimiento 
     * @ORM\Column(type="date", nullable=true)
     */
    private $FechaVencimiento;

    
    public function __toString() {
        return 'Matriculado Nº ' . $this->getNumero() . ': ' . $this->getPersona()->getNombreVisible();
    }
    
    public function getProfesion() {
        return $this->Profesion;
    }

    public function setProfesion($Profesion) {
        $this->Profesion = $Profesion;
    }
    
    public function getPersona() {
        return $this->Persona;
    }

    public function setPersona($Persona) {
        $this->Persona = $Persona;
    }
    
    public function getFechaVencimiento() {
        return $this->FechaVencimiento;
    }

    public function setFechaVencimiento($FechaVencimiento) {
        $this->FechaVencimiento = $FechaVencimiento;
    }
    
    public function getNumero() {
        return $this->Numero;
    }

    public function setNumero($Numero) {
        $this->Numero = $Numero;
    }
}
