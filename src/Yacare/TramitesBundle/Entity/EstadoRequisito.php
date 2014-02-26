<?php
/*
 * Representa el estado de un requisito dentro de un trámite.
 */
namespace Yacare\TramitesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\TramitesBundle\Entity\TramiteRequisito
 *
 * @ORM\Entity(repositoryClass="Yacare\BaseBundle\Entity\YacareBaseRepository")
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
    use \Yacare\BaseBundle\Entity\ConAdjuntos;
    
    /**
     * @ORM\ManyToOne(targetEntity="Tramite", inversedBy="EstadosRequisitos")
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
    protected $Estado = 0;
    
    
    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $FechaAprobado;
    
    
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
        
        /*
         * Busco recursivamente las propiedades.
         * Por ejemplo, "Titular.NumeroDocumento" se convierte en
         * "$this->getTramite()->getTitular()->getNumeroDocumento()"
         */
        $Propiedades = explode('.', $Asoc->getCondicionQue());
        $Objeto = $this->getTramite();
        $ValorQue = null;
        foreach ($Propiedades as $Propiedad) {
            $NombreMetodo = 'get' . $Propiedad;
            //echo $NombreMetodo . '; ';
            if(method_exists($Objeto, $NombreMetodo)) {
                $ValorQue = $Objeto->$NombreMetodo();
                $Objeto = $ValorQue;
            } else {
                $ValorQue = null;
                break;
            }
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
    
    public static function NombreEstado($estado) {
        switch($estado) {
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
    
    public function getEstadoNombre() {
        return EstadoRequisito::NombreEstado($this->Estado);
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
    
    public function getFechaAprobado() {
        return $this->FechaAprobado;
    }

    public function setFechaAprobado(\DateTime $FechaAprobado) {
        $this->FechaAprobado = $FechaAprobado;
    }
}