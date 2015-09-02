<?php
namespace Yacare\ObrasParticularesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Representa un matriculado.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 *
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Table(name="ObrasParticulares_Matriculado")
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
     * @var \Yacare\BaseBundle\Entity\Persona
     *
     * @ORM\ManyToOne(targetEntity="Yacare\BaseBundle\Entity\Persona")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=false)
     */
    private $Persona;
    
    /**
     * Indica la profesion del matriculado
     *
     * @var string
     * 
     * @ORM\Column(type="string", nullable=false)
     */
    private $Profesion;
    
    /**
     * La fecha de vencimiento del pago anual.
     *
     * @var \Date
     * 
     * @ORM\Column(type="date", nullable=true)
     */
    private $FechaVencimiento;

    public function __toString()
    {
        return 'Matriculado Nº ' . $this->getId() . ': ' . $this->getPersona()->getNombreVisible();
    }

    /**
     * Devuelve el nombre abreviado de la profesión.
     * 
     * @return string nombre abreviado.
     */
    public function getProfesionAbreviada()
    {
        switch ($this->Profesion) {
            case 'Ingeniero civil':
                return 'Ing. civil';
            case 'Ingeniero en construcciones':
                return 'Ing. en constr.';
            case 'Arquitecto':
                return 'Arq.';
            case 'Maestro mayor de obras':
                return 'M.M.O.';
            case 'Técnico constructor':
                return 'Téc. constr.';
            default:
                return $this->Profesion;
        }
    }

    /**
     * @ignore
     */
    public function getNombre()
    {
        return (string) $this;
    }

    /**
     * @ignore
     */
    public function getProfesion()
    {
        return $this->Profesion;
    }

    /**
     * @ignore
     */
    public function setProfesion($Profesion)
    {
        $this->Profesion = $Profesion;
    }

    /**
     * @ignore
     */
    public function getPersona()
    {
        return $this->Persona;
    }

    /**
     * @ignore
     */
    public function setPersona($Persona)
    {
        $this->Persona = $Persona;
    }

    /**
     * @ignore
     */
    public function getFechaVencimiento()
    {
        return $this->FechaVencimiento;
    }

    /**
     * @ignore
     */
    public function setFechaVencimiento($FechaVencimiento)
    {
        $this->FechaVencimiento = $FechaVencimiento;
    }
}
