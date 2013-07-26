<?php

namespace Yacare\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\BaseBundle\Entity\PersonaGrupo
 *
 * @ORM\Table(name="Base_PersonaGrupo")
 * @ORM\Entity
 */
class PersonaGrupo
{
    use \Yacare\BaseBundle\Entity\ConId;
    use \Yacare\BaseBundle\Entity\ConNombre;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    use \Yacare\BaseBundle\Entity\Versionable;
    
    public function __construct()
    {
        $this->Personas = new \Doctrine\Common\Collections\ArrayCollection();
    }      
    
    
    /**
     * @ORM\ManyToMany(targetEntity="Persona", mappedBy="Grupos", cascade={"persist"})
     */
    protected $Personas;


    /**
     * @ORM\ManyToOne(targetEntity="Yacare\BaseBundle\Entity\PersonaGrupo")
     * @ORM\JoinColumn(name="Parent", referencedColumnName="id", nullable=true)
     */
    private $Parent;
    
    public function setParent($parent)
    {
        $this->Parent = $parent;
    }

    public function getParent()
    {
        return $this->Parent;
    }
}
