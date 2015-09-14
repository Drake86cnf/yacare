<?php
namespace Yacare\RecursosHumanosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Representa una novedad o movimiento en un cargo de un agente.
 *
 * @author Ezequiel Riquelme <rezequiel.tdf@gmail.com>
 * 
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Table(name="Rrhh_AgenteCargoMovim")
 */
class AgenteCargoMovim
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    
    /**
     * El agente.
     * 
     * @var Agente
     *
     * @ORM\ManyToOne(targetEntity="Agente", cascade={"persist"})
     * @ORM\JoinColumn(referencedColumnName="id", nullable=false)
     */
    private $Agente;
    
    /**
     * El cargo.
     * 
     * @var Cargo
     *
     * @ORM\ManyToOne(targetEntity="Cargo", cascade={"persist"})
     * @ORM\JoinColumn(referencedColumnName="id", nullable=false)
     */
    private $Cargo;
    
    /**
     * La fecha de la novedad.
     * 
     * @var \Date
     *
     * @ORM\Column(type="date", nullable=false)
     * @Assert\Date(message="Por favor proporcione la fecha de la novedad.")
     */
    private $Fecha;

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
    public function getCargo()
    {
        return $this->Cargo;
    }

    /**
     * @ignore
     */
    public function setCargo($Cargo)
    {
        $this->Cargo = $Cargo;
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
}
