<?php
namespace Yacare\ObrasParticularesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\ObrasParticularesBundle\Entity\Matriculado
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
     * @ORM\ManyToOne(targetEntity="Yacare\BaseBundle\Entity\Persona")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=false)
     */
    private $Persona;

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

    public function getNombre()
    {
        return (string) $this;
    }

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

    public function __toString()
    {
        return 'Matriculado Nº ' . $this->getId() . ': ' . $this->getPersona()->getNombreVisible();
    }

    public function getProfesion()
    {
        return $this->Profesion;
    }

    public function setProfesion($Profesion)
    {
        $this->Profesion = $Profesion;
    }

    public function getPersona()
    {
        return $this->Persona;
    }

    public function setPersona($Persona)
    {
        $this->Persona = $Persona;
    }

    public function getFechaVencimiento()
    {
        return $this->FechaVencimiento;
    }

    public function setFechaVencimiento($FechaVencimiento)
    {
        $this->FechaVencimiento = $FechaVencimiento;
    }
}
