<?php
namespace Yacare\RecursosHumanosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Representa un cargo designado a uno o más agentes.
 *
 * @author Ezequiel Riquelme <rezequiel.tdf@gmail.com>
 *        
 *         @ORM\Table(name="Rrhh_AgenteCargo")
 *         @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 */
class AgenteCargo
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
     * El historial de cargos asignados.
     *
     * @ORM\OneToMany(targetEntity="Agente", mappedBy="Cargo")
     */
    private $Agentes;

    /**
     *
     * @ignore
     *
     */
    public function setAgentes($Agentes)
    {
        return $this->Agentes = $Agentes;
    }

    /**
     *
     * @ignore
     *
     */
    public function getAgentes()
    {
        return $this->Agentes;
    }
}