<?php
namespace Yacare\ObrasParticularesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\ObrasParticularesBundle\Entity\EmpresaConstructora
 *
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Table(name="ObrasParticulares_EmpresaConstructora")
 */
class EmpresaConstructora
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Tapir\BaseBundle\Entity\Suprimible;
    use \Tapir\BaseBundle\Entity\Archivable;
    use \Tapir\BaseBundle\Entity\Versionable;

    /**
     * La persona juŕidica asociada.
     *
     * @ORM\ManyToOne(targetEntity="Yacare\BaseBundle\Entity\Persona")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=false)
     */
    private $Persona;

    /**
     * El representante técnico.
     *
     * @ORM\ManyToOne(targetEntity="Yacare\ObrasParticularesBundle\Entity\Matriculado")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=false)
     */
    private $RepresentanteTecnico;

    /**
     * La fecha de vencimiento del pago anual.
     *
     * @var $FechaVencimiento @ORM\Column(type="date", nullable=true)
     */
    private $FechaVencimiento;

    public function __toString()
    {
        return 'Empresa Constructura Nº ' . $this->getId() . ': ' . $this->getPersona()->getNombreVisible();
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

    public function getRepresentanteTecnico()
    {
        return $this->RepresentanteTecnico;
    }

    public function setRepresentanteTecnico($RepresentanteTecnico)
    {
        $this->RepresentanteTecnico = $RepresentanteTecnico;
        return $this;
    }
}
