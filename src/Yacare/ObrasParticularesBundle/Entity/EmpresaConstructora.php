<?php
namespace Yacare\ObrasParticularesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Representa una empresa constructora.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
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
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    
    /**
     * La persona juŕidica asociada.
     * 
     * @var \Yacare\BaseBundle\Entity\Persona
     *
     * @ORM\ManyToOne(targetEntity="Yacare\BaseBundle\Entity\Persona")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=false)
     */
    private $Persona;
    
    /**
     * El representante técnico.
     * 
     * @var \Yacare\ObrasParticularesBundle\Entity\Matriculado
     *
     * @ORM\ManyToOne(targetEntity="Yacare\ObrasParticularesBundle\Entity\Matriculado")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=false)
     */
    private $RepresentanteTecnico;
    
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
        return $this->getPersona()->getNombreVisible();
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

    /**
     * @ignore
     */
    public function getRepresentanteTecnico()
    {
        return $this->RepresentanteTecnico;
    }

    /**
     * @ignore
     */
    public function setRepresentanteTecnico($RepresentanteTecnico)
    {
        $this->RepresentanteTecnico = $RepresentanteTecnico;
        return $this;
    }
}
