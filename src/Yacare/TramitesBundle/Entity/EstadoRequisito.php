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
     * @ORM\ManyToOne(targetEntity="EstadoRequisito")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $EstadoRequisitoPadre;


    /**
     * @ORM\Column(type="integer")
     */
    private $Estado = 0;

    /*
     * Devuelve si este requisito es necesario para este trámite.
     */
    public function EsNecesario() {
        if($this->getEstadoRequisitoPadre()) {
            // Es un sub-requisito. Evaluo también si el parent es necesario.
            return $this->CondicionSeCumple() && $this->getEstadoRequisitoPadre()->EsNecesario();
        } else {
            return $this->CondicionSeCumple();
        }
    }
    
    public function EsOpcional() {
        if($this->getEstadoRequisitoPadre()) {
            // Es un sub-requisito. Evaluo también si el parent es opcional.
            return $this->getAsociacionRequisito()->getOpcional() || $this->getEstadoRequisitoPadre()->EsOpcional();
        } else {
            return $this->getAsociacionRequisito()->getOpcional();
        }
    }
    
    
    public function EstaCumplido() {
        return $this->EsNecesario() == false 
                || $this->EsOpcional()
                || $this->getEstado() >= 99;
    }
    
    
    /*
     * Devuelve si esta condición se cumple.
     */
    public function CondicionSeCumple() {
        $Asoc = $this->getAsociacionRequisito();

        if(!$Asoc->getCondicionQue()) {
            // No hay condición... lo doy siempre por cumplido
            return true;
        }
        
        $FuncQue = 'get' . str_replace('.', '()->get', $Asoc->getCondicionQue());
        //$ValorQue = $this->getTramite()->$FuncQue();
        try {
            $ValorQue = @eval('$this->getTramite()->' . $FuncQue . '();');
        } catch(Exception $e) {
            $ValorQue = null;
        }
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
        return ((string)$this->getAsociacionRequisito()) . ' en estado ' . $this->getEstadoNombre();
    }
    
    public function getEstadoNombre() {
        switch($this->Estado) {
            case 0: return 'Faltante';
            case 10: return 'Observado';
            case 15: return 'Rechazado';
            case 90: return 'Desestimado';
            case 95: return 'Presentado, aprobación pendiente';
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
    
    public function getEstadoRequisitoPadre() {
        return $this->EstadoRequisitoPadre;
    }

    public function setEstadoRequisitoPadre($EstadoRequisitoPadre) {
        $this->EstadoRequisitoPadre = $EstadoRequisitoPadre;
    }
}