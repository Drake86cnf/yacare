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
    protected $FechaHoraInspeccion;

    /**
     * El estado del turno.
     *
     * @var Estado @ORM\Column(type= "integer", nullable=true)
     */
    protected $EstadoTurno;

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
     *
     * @ignore
     *
     */
    public function getFechaHoraInspeccion()
    {
        return $this->FechaHoraInspeccion;
    }

    /**
     *
     * @ignore
     *
     */
    public function setFechaHoraInspeccion($FechaHoraInspeccion)
    {
        $this->FechaHoraInspeccion = $FechaHoraInspeccion;
        return $this;
    }

    /**
     *
     * @ignore
     *
     */
    public function getEstadoTurno()
    {
        return $this->EstadoTurno;
    }

    /**
     *
     * @ignore
     *
     */
    public function setEstadoTurno($EstadoTurno)
    {
        $this->EstadoTurno = $EstadoTurno;
        return $this;
    }
}