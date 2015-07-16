<?php
namespace Yacare\RecursosHumanosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Representa un grupo de agentes.
 *
 * @author Ernesto Carrea <equistango@gmail.com>
 *        
 *         @ORM\Table(name="Rrhh_AgenteGrupo")
 *         @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 */
class AgenteGrupo
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Tapir\BaseBundle\Entity\ConNombre;
    use \Tapir\BaseBundle\Entity\ConObs;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    use \Tapir\BaseBundle\Entity\Versionable;
    use \Tapir\BaseBundle\Entity\Suprimible;

    public function __construct()
    {
        $this->Agentes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Los agentes que pertenecen a este grupo.
     *
     * @ORM\ManyToMany(targetEntity="Agente", mappedBy="Grupos", cascade={"persist"})
     */
    protected $Agentes;

    /**
     * El grupo de nivel superior.
     *
     * @ORM\ManyToOne(targetEntity="Yacare\RecursosHumanosBundle\Entity\AgenteGrupo")
     * @ORM\JoinColumn(name="Parent", referencedColumnName="id", nullable=true)
     */
    private $Parent;

    /**
     * Indica el nombre del grupo en el servidor LDAP, si está asociado.
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $NombreLdap;

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
    public function getNombreLdap()
    {
        return $this->NombreLdap;
    }

    /**
     *
     * @ignore
     *
     */
    public function setNombreLdap($NombreLdap)
    {
        $this->NombreLdap = $NombreLdap;
        return $this;
    }
}
