<?php
namespace Yacare\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\BaseBundle\Entity\Comentario
 *
 * @ORM\Table(name="Base_Comentario")
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 */
class Comentario
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Tapir\BaseBundle\Entity\ConObs;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    
    /**
     * @var $EntidadTipo @ORM\Column(type="string", length=255)
     */
    private $EntidadTipo;
    
    /**
     * @var $EntidadId @ORM\Column(type="integer")
     */
    private $EntidadId;
    
    /**
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
