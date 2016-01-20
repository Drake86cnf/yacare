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

    /**
     * El estado del turno.
     *
     * @var Estado @ORM\Column(type= "integer", nullable=true)
     */
    protected $TurnoEstado;

    public function getNombreEstado($EstadoTurno)
    {
        switch ($EstadoTurno) {
            case 0:
                return 'Activo';
            case 1:
                return 'Terminado';
            case 2:
                return 'Cancelado';
            case 3:
                return 'Vencido';
            default:
                return 'Sin turno';
        }
    }

    /**
     * Devuelve true si el estado del turno esta vencido.
     */
    public function EstaVencida()
    {
        $FechaHoraInspeccion = $this->getFechaHoraInspeccion();
        if ($FechaHoraInspeccion) {
            $Ahora = new \DateTime();
            return $Ahora > $FechaHoraInspeccion;
        } else {
            // No tiene fecha de vencimiento
            return false;
        }
    }

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
        $fechahora = explode(" ",$FechaHoraInspeccion);
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

    /**
     * @ignore
     */
    public function getTurnoEstado()
    {
        return $this->TurnoEstado;
    }

    /**
     * @ignore
     */
    public function setTurnoEstado($TurnoEstado)
    {
        $this->TurnoEstado = $TurnoEstado;
        return $this;
    }
}
