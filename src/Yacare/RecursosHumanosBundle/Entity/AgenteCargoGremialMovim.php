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
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Table(name="Rrhh_AgenteCargoGremialMovim")
 */
class AgenteCargoGremialMovim
{
    use \Tapir\BaseBundle\Entity\ConId;
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
     * El gremio.
     * 
     * @var \Yacare\RecursosHumanosBundle\Entity\Gremio
     *
     * @ORM\ManyToOne(targetEntity="Gremio", cascade={"persist"})
     * @ORM\JoinColumn(referencedColumnName="id", nullable=false)
     */
    private $Gremio;
    
    /**
     * El cargo.
     * 
     * @var integer
     *
     * @Column(type="integer", nullable=true)
     */
    private $CargoGremial;
    
    /**
     * La fecha de alta.
     * 
     * @var \DateTime
     *
     * @ORM\Column(type="date", nullable=true)
     * @Assert\Type("\DateTime")
     */
    private $FechaAlta;
    
    /**
     * La fecha de baja. 
     * *NULL si aún está activo en el cargo.
     * 
     * @var \DateTime
     *
     * @ORM\Column(type="date", nullable=true)
     * @Assert\Type("\DateTime")
     */
    private $FechaBaja;
    
    /**
     * La fecha de la novedad.
     * 
     * @var \DateTime
     *
     * @ORM\Column(type="date", nullable=false)
     * @Assert\Type("\DateTime")
     */
    private $Fecha;

    /**
     * Normaliza nombres de cargos gremiales.
     * 
     * @return string
     * 
     * @see $CargoGremial $CargoGremial
     */
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
     * @return string
     *
     * @see $CargoGremial $CargoGremial
     */
    public function getCargoGremialNombre()
    {
        return AgenteCargoGremialMovim::CargosGremialesNombres($this->getCargoGremial());
    }

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
    public function getGremio()
    {
        return $this->Gremio;
    }

    /**
     * @ignore
     */
    public function setGremio($Gremio)
    {
        $this->Gremio = $Gremio;
        return $this;
    }

    /**
     * @ignore
     */
    public function getCargoGremial()
    {
        return $this->CargoGremial;
    }

    /**
     * @ignore
     */
    public function setCargoGremial($CargoGremial)
    {
        $this->CargoGremial = $CargoGremial;
        return $this;
    }

    /**
     * @ignore
     */
    public function getFechaAlta()
    {
        return $this->FechaAlta;
    }

    /**
     * @ignore
     */
    public function setFechaAlta($FechaAlta)
    {
        $this->FechaAlta = $FechaAlta;
        return $this;
    }

    /**
     * @ignore
     */
    public function getFechaBaja()
    {
        return $this->FechaBaja;
    }

    /**
     * @ignore
     */
    public function setFechaBaja($FechaBaja)
    {
        $this->FechaBaja = $FechaBaja;
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
