<?php
/*
 * Representa el estado de un requisito dentro de un trámite.
 */
namespace Yacare\TramitesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\TramitesBundle\Entity\TramiteRequisito
 *
 * @ORM\Entity
 * @ORM\Table(name="Tramites_EstadoRequisito")
 */
class EstadoRequisito
{
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Tramite")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $Tramite;


    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="AsociacionRequisito")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $AsociacionRequisito;
    
    /**
     * @ORM\ManyToOne(targetEntity="TramiteTipo")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $TramiteTipoOrigen;


    /**
     * @ORM\Column(type="integer")
     */
    private $Estado;

    
    public function getEstadoNombre() {
        switch($this->Estado) {
            case 0: return 'Faltante';
            case 10: return 'Observado';
            case 15: return 'Rechazado';
            case 90: return 'Desestimado';
            case 95: return 'Presentado pendiente de aprobación';
            case 100: return 'Aprobado';
            default: return '???';
        }
    }
    
    public function getEstado() {
        return $this->Estado;
    }

    public function setEstado($Estado) {
        $this->Estado = $Estado;
    }
    
    public function getTramite() {
        return $this->Tramite;
    }

    public function setTramite($Tramite) {
        $this->Tramite = $Tramite;
    }

    public function getAsociacionRequisito() {
        return $this->AsociacionRequisito;
    }

    public function setAsociacionRequisito($AsociacionRequisito) {
        $this->AsociacionRequisito = $AsociacionRequisito;
    }
    
    public function getTramiteTipoOrigen() {
        return $this->TramiteTipoOrigen;
    }

    public function setTramiteTipoOrigen($TramiteTipoOrigen) {
        $this->TramiteTipoOrigen = $TramiteTipoOrigen;
    }
}