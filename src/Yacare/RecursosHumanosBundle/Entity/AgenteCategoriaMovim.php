<?php
namespace Yacare\RecursosHumanosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping\Column;

/**
 * Representa una novedad o movimiento en una categoría de un agente.
 *
 * @author Ezequiel Riquelme <rezequiel.tdf@gmail.com>
 *
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Table(name="Rrhh_AgenteCategoriaMovim")
 */
class AgenteCategoriaMovim
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Yacare\AdministracionBundle\Entity\ConActoAdministrativo;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;

    /**
     * El agente.
     *
     * @var \Yacare\RecursosHumanosBundle\Entity\Agente
     *
     * @ORM\ManyToOne(targetEntity="Agente", cascade={"persist"})
     * @ORM\JoinColumn(referencedColumnName="id", nullable=false)
     */
    private $Agente;

    /**
     * El cargo.
     *
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    private $Categoria;

    /**
     * La fecha de la novedad.
     *
     * @var \Date
     *
     * @ORM\Column(type="date", nullable=false)
     * @Assert\Date(message="Por favor proporcione una fecha para la novedad.")
     */
    private $Fecha;

    /**
     * La fecha de la novedad.
     *
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $ACargo;

    // *** Getters y setters

    /**
     * @ignore
     */
    public function getAgente()
    {
        return $this->Agente;
    }

    /**
     * @ignore
     */
    public function setAgente($Agente)
    {
        $this->Agente = $Agente;
        return $this;
    }

    /**
     * @ignore
     */
    public function getCategoria()
    {
        return $this->Categoria;
    }

    /**
     * @ignore
     */
    public function setCategoria($Categoria)
    {
        $this->Categoria = $Categoria;
        return $this;
    }

    /**
     * @ignore
     */
    public function getFecha()
    {
        return $this->Fecha;
    }

    /**
     * @ignore
     */
    public function setFecha($Fecha)
    {
        $this->Fecha = $Fecha;
        return $this;
    }

    /**
     * @ignore
     */
    public function getACargo()
    {
        return $this->ACargo;
    }

    /**
     * @ignore
     */
    public function setACargo($ACargo)
    {
        $this->ACargo = $ACargo;
        return $this;
    }
}
