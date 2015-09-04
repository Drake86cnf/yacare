<?php
namespace Yacare\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\BaseBundle\Entity\Comentario
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 *
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Table(name="Base_Comentario")
 */
class Comentario
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Tapir\BaseBundle\Entity\ConObs;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    
    /**
     * EL tipo de la entidad.
     * 
     * @var string 
     * 
     * @ORM\Column(type="string", length=255)
     */
    private $EntidadTipo;
    
    /**
     * La ID de la entidad.
     * 
     * @var integer 
     * 
     * @ORM\Column(type="integer")
     */
    private $EntidadId;
    
    /**
     * La persona.
     * 
     * @var \Yacare\BaseBundle\Entity\Persona
     * 
     * @ORM\ManyToOne(targetEntity="\Yacare\BaseBundle\Entity\Persona")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $Persona;

    /**
     * @ignore
     */
    public function getEntidadTipo()
    {
        return $this->EntidadTipo;
    }

    /**
     * @ignore
     */
    public function setEntidadTipo($EntidadTipo)
    {
        $this->EntidadTipo = $EntidadTipo;
    }

    /**
     * @ignore
     */
    public function getEntidadId()
    {
        return $this->EntidadId;
    }

    /**
     * @ignore
     */
    public function setEntidadId($EntidadId)
    {
        $this->EntidadId = $EntidadId;
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
}
