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
 *         @ORM\Table(name="Rrhh_AgenteCategoriaMovim")
 *         @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 */
class AgenteCategoriaMovim
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    use \Yacare\AdministracionBundle\Entity\ConDecreto;

    /**
     * El agente.
     *
     * @ORM\ManyToOne(targetEntity="Agente", cascade={"persist"})
     * @ORM\JoinColumn(referencedColumnName="id", nullable=false)
     */
    private $Agente;

    /**
     * El cargo.
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    private $Categoria;

    /**
     * La categoría anterior.
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $CategoriaAnterior;

    /**
     * La fecha de la novedad.
     *
     * @ORM\Column(type="date", nullable=false)
     * @Assert\Type("\DateTime")
     */
    private $Fecha;

    /**
     *
     * @ignore
     *
     */
    public function setAgente($Agente)
    {
        return $this->Agente = $Agente;
    }

    /**
     *
     * @ignore
     *
     */
    public function getAgente()
    {
        return $this->Agente;
    }

    /**
     *
     * @ignore
     *
     */
    public function setCategoria($Categoria)
    {
        return $this->Categoria = $Categoria;
    }

    /**
     *
     * @ignore
     *
     */
    public function getCategoria()
    {
        return $this->Categoria;
    }

    /**
     *
     * @ignore
     *
     */
    public function setCategoriaAnterior($CategoriaAnterior)
    {
        return $this->CategoriaAnterior = $CategoriaAnterior;
    }

    /**
     *
     * @ignore
     *
     */
    public function getCategoriaAnterior()
    {
        return $this->CategoriaAnterior;
    }

    /**
     *
     * @ignore
     *
     */
    public function setFecha($Fecha)
    {
        return $this->Fecha = $Fecha;
    }

    /**
     *
     * @ignore
     *
     */
    public function getFecha()
    {
        return $this->Fecha;
    }
}