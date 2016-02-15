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
     * El número de matrícula en el sistema viejo.
     *
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $Numero;
    
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
     * El nombre de fantasía.
     *
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $NombreFantasia;
    
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
        if($this->getNombreFantasia()) {
            return $this->getNombreFantasia();
        } else {
            return $this->getPersona()->getNombreVisible();
        }
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

    /**
     * @ignore
     */
    public function getNombreFantasia()
    {
        return $this->NombreFantasia;
    }

    /**
     * @ignore
     */
    public function setNombreFantasia($NombreFantasia)
    {
        $this->NombreFantasia = $NombreFantasia;
        return $this;
    }

    /**
     * @ignore
     */
    public function getNumero()
    {
        return $this->Numero;
    }

    /**
     * @ignore
     */
    public function setNumero($Numero)
    {
        $this->Numero = $Numero;
        return $this;
    }
 
 
}
