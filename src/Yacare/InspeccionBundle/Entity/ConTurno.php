<?php
namespace Yacare\InspeccionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Agrega la característica de tener un turno de inspección.
 */
trait ConTurno
{
    
    /**
     * La fecha de inspeccion pautada.
     *
     * @var \DateTime @ORM\Column(type="datetime", nullable=true)
     *     
     */
    protected $TurnoFecha;

    public function getHoraTurno()
    {
        if ($this->FechaHoraInspeccion) {
            $fechahora = str_split($this->FechaHoraInspeccion, 8);
            return $fechahora[1];
        }
    }

    public function getFechaTurno()
    {
        if ($this->FechaHoraInspeccion) {
            $fechahora = str_split($this->FechaHoraInspeccion, 8);
            return $fechahora[0];
        }
    }

    public function setHoraTurno($FechaHoraInspeccion)
    {
        $fechahora = explode(" ", $FechaHoraInspeccion);
        $fechahora[1] = $FechaHoraInspeccion;
        return $this;
    }

    public function setFechaTurno($FechaHoraInspeccion)
    {
        $fechahora = explode(" ", $FechaHoraInspeccion);
        $fechahora[0] = $FechaHoraInspeccion;
        return $this;
    }

    /**
     * @ignore
     */
    public function getTurnoFecha()
    {
        return $this->TurnoFecha;
    }

    /**
     * @ignore
     */
    public function setTurnoFecha(\DateTime $TurnoFecha)
    {
        $this->TurnoFecha = $TurnoFecha;
        return $this;
    }
}
