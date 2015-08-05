<?php
namespace Yacare\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Representa un grupo de personas.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 *        
 * @ORM\Table(name="Base_PersonaGrupo")
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 */
class PersonaGrupo
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Tapir\BaseBundle\Entity\ConNombre;
    use \Tapir\BaseBundle\Entity\ConObs;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    use \Tapir\BaseBundle\Entity\Versionable;
    use \Tapir\BaseBundle\Entity\Suprimible;

    public function __construct()
    {
        $this->Personas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Las personas que pertenecen a este grupo.
     *
     * @ORM\ManyToMany(targetEntity="Persona", mappedBy="Grupos", cascade={"persist"})
     */
    protected $Personas;

    /**
     * El grupo de nivel superior.
     *
     * @ORM\ManyToOne(targetEntity="Yacare\BaseBundle\Entity\PersonaGrupo")
     * @ORM\JoinColumn(name="Parent", referencedColumnName="id", nullable=true)
     */
    private $Parent;

    /**
     * Indica si el grupo se replica al servidor de dominio.
     *
     * @ORM\Column(type="boolean")
     */
    private $Dominio = false;

    /**
     *
     * @ignore
     *
     */
    public function setParent($parent)
    {
        $this->Parent = $parent;
    }

    /**
     *
     * @ignore
     *
     */
    public function getParent()
    {
        return $this->Parent;
    }

    /**
     *
     * @ignore
     *
     */
    public function getDominio()
    {
        return $this->Dominio;
    }

    /**
     *
     * @ignore
     *
     */
    public function setDominio($Dominio)
    {
        $this->Dominio = $Dominio;
        return $this;
    }
}
