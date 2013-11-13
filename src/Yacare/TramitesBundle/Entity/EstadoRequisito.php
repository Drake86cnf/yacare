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
 * @ORM\Table(name="Tramites_EstadoRequisito",
 *      uniqueConstraints={
 *          @ORM\UniqueConstraint(name="TramiteAsociacionRequisito", columns={"Tramite_id", "AsociacionRequisito_id"})
 *      },
 *      indexes={
 *          @ORM\Index(name="Tramites_EstadoRequisito_Tramite", columns={"Tramite_id"})
 *      }
 * )
 */
class EstadoRequisito
{
    use \Yacare\BaseBundle\Entity\ConId;
    use \Yacare\BaseBundle\Entity\ConObs;
    
    /**
     * @ORM\ManyToOne(targetEntity="Tramite")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $Tramite;


    /**
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
    
    /*
     * Devuelve si este requisito es necesario para este trámite.
     */
    public function EsNecesario() {
        $Asoc = $this->getAsociacionRequisito();
        
        if($Asoc->getCondicionQue()) {
            return $this->CondicionSeCumple();
        } else {
            return true;
        }
    }
    
    
    /*
     * Devuelve si esta condición se cumple.
     */
    public function CondicionSeCumple() {
        $Asoc = $this->getAsociacionRequisito();

        if(!$Asoc->getCondicionQue())
            return true;
        
        $FuncQue = 'get' . str_replace('.', '()->get', $Asoc->getCondicionQue());
        //$ValorQue = $this->getTramite()->$FuncQue();
        $ValorQue = eval('$this->getTramite()->' . $FuncQue . '();');
        $ValorCuanto = $Asoc->getCondicionCuanto();
        
        switch($Asoc->getCondicionEs()) {
            case '==': return $ValorQue == $ValorCuanto;
            case '!=': return $ValorQue != $ValorCuanto;
            case '>': return $ValorQue > $ValorCuanto;
            case '>=': return $ValorQue >= $ValorCuanto;
            case '<': return $ValorQue < $ValorCuanto;
            case '<=': return $ValorQue <= $ValorCuanto;
            case 'null': return $ValorQue == null;
            case 'not null': return $ValorQue != null;
            case 'true': return (bool)$ValorQue;
            case 'false': return !((bool)$ValorQue);
        }
        return false;
    }

    
    public function __toString() {
        return (string)$this->getAsociacionRequisito();
    }
    
    public function getEstadoNombre() {
        switch($this->Estado) {
            case 0: return 'Faltante';
            case 10: return 'Observado';
            case 15: return 'Rechazado';
            case 90: return 'Desestimado';
            case 95: return 'Presentado pendiente de aprobación';
            case 99: return 'No es necesario';
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