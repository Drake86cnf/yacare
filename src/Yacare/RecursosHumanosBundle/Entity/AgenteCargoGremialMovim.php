<?php
namespace Yacare\RecursosHumanosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping\Column;

/**
 * Representa una novedad o movimiento en un cargo gremial de un agente.
 *
 * @author Ezequiel Riquelme <rezequiel.tdf@gmail.com>
 *        
 * @ORM\Table(name="Rrhh_AgenteCargoGremialMovim")
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 */
class AgenteCargoGremialMovim
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;

    /**
     * El agente.
     *
     * @ORM\ManyToOne(targetEntity="Agente", cascade={"persist"})
     * @ORM\JoinColumn(referencedColumnName="id", nullable=false)
     */
    private $Agente;

    /**
     * El gremio.
     *
     * @ORM\ManyToOne(targetEntity="Gremio", cascade={"persist"})
     * @ORM\JoinColumn(referencedColumnName="id", nullable=false)
     */
    private $Gremio;

    /**
     * El cargo.
     *
     * @Column(type="integer", nullable=true)
     */
    private $CargoGremial;

    /**
     * La fecha de alta.
     *
     * @ORM\Column(type="date", nullable=true)
     * @Assert\Type("\DateTime")
     */
    private $FechaAlta;

    /**
     * La fecha de baja.
     * NULL si aún está activo en el cargo.
     *
     * @ORM\Column(type="date", nullable=true)
     * @Assert\Type("\DateTime")
     */
    private $FechaBaja;

    /**
     * La fecha de la novedad.
     *
     * @ORM\Column(type="date", nullable=false)
     * @Assert\Type("\DateTime")
     */
    private $Fecha;

    public static function CargosGremialesNombres($rango)
    {
        switch ($rango) {
            case 0:
                return 'Sin cargo';
            case 1:
                return 'Delegado';
            case 2:
                return 'Congresal';
            case 3:
                return 'Comisión directiva';
            default:
                return '';
        }
    }

    /**
     * Obtiene el nombre del cargo gremial.
     *
     * @see $CargoGremial
     */
    public function getCargoGremialNombre()
    {
        return AgenteCargoGremialMovim::CargosGremialesNombres($this->getCargoGremial());
    }

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
    public function setGremio($Gremio)
    {
        return $this->Gremio = $Gremio;
    }

    /**
     *
     * @ignore
     *
     */
    public function getGremio()
    {
        return $this->Gremio;
    }

    /**
     *
     * @ignore
     *
     */
    public function setCargoGremial($CargoGremial)
    {
        return $this->CargoGremial = $CargoGremial;
    }

    /**
     *
     * @ignore
     *
     */
    public function getCargoGremial()
    {
        return $this->CargoGremial;
    }

    /**
     *
     * @ignore
     *
     */
    public function setFechaAlta($FechaAlta)
    {
        return $this->FechaAlta = $FechaAlta;
    }

    /**
     *
     * @ignore
     *
     */
    public function getFechaAlta()
    {
        return $this->FechaAlta;
    }

    /**
     *
     * @ignore
     *
     */
    public function setFechaBaja($FechaBaja)
    {
        return $this->FechaBaja = $FechaBaja;
    }

    /**
     *
     * @ignore
     *
     */
    public function getFechaBaja()
    {
        return $this->FechaBaja;
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