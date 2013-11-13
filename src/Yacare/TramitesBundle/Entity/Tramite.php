<?php

namespace Yacare\TramitesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\TramitesBundle\Entity\Tramite
 *
 * @ORM\Entity
 * @ORM\Table(name="Tramites_Tramite")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="TramiteTipo", type="string")
 * @ORM\DiscriminatorMap({
 *      "\Yacare\ComercioBundle\Entity\TramiteHabilitacionComercial" = "\Yacare\ComercioBundle\Entity\TramiteHabilitacionComercial"
 * })
 */
class Tramite
{
    use \Yacare\BaseBundle\Entity\ConId;
    use \Yacare\BaseBundle\Entity\ConNombre;
    use \Yacare\BaseBundle\Entity\ConObs;
    use \Yacare\BaseBundle\Entity\Versionable;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;

    use \Yacare\TramitesBundle\Entity\ConTitular;
    
    public function __construct()
    {
        $this->EstadoRequisitos = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * @ORM\Column(type="integer")
     */
    private $Estado;
    
    /**
     * @ORM\ManyToOne(targetEntity="TramiteTipo")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $TramiteTipo;
    
    /**
     * @ORM\OneToMany(targetEntity="EstadoRequisito", mappedBy="Tramite", cascade={"persist"})
     * @ORM\JoinTable(name="Tramites_Tramite_EstadoRequisito",
     *      joinColumns={@ORM\JoinColumn(name="Tramite_id", referencedColumnName="Tramite_id")}
     * )
     */
    private $EstadosRequisitos;
    
    public function EstaEnCurso() {
        return $this->getEstado() < 90;
    }
    
    
    public function PorcentajeCompleto() {
        if($this->RequisitosObligatoriosCantidad() == 0) {
            return 0;
        } else {
            return round((1 - $this->RequisitosFaltantesCantidad() / $this->RequisitosObligatoriosCantidad()) * 100);
        }
    }
    
    
    /*
     * Devuelve la cantidad de requisitos obligatorios totales.
     */
    public function RequisitosObligatoriosCantidad() {
        $res = 0;
        foreach ($this->EstadosRequisitos as $EstadoRequisito) {
            if($EstadoRequisito->EsNecesario() && $EstadoRequisito->EsOpcional() == false) {
                $res++;
            }
        }
        return $res;
    }
    
    
    /*
     * Devuelve la cantidad de requisitos obligatorios faltantes.
     */
    public function RequisitosFaltantesCantidad() {
        $res = 0;
        foreach ($this->EstadosRequisitos as $EstadoRequisito) {
            if($EstadoRequisito->EsNecesario() && $EstadoRequisito->EsOpcional() == false && $EstadoRequisito->EstaCumplido() == false) {
                $res++;
            }
        }
        return $res;
    }
    
    
    public function ExplicarEstadosRequisitos() {
        $res = array();
        foreach ($this->EstadosRequisitos as $EstadoRequisito) {
            if($EstadoRequisito->EsNecesario() && $EstadoRequisito->EstaCumplido() == false) {
                $res[] = 'Falta ' . (string)$EstadoRequisito;
            }
        }
        
        if(count($res) == 0) {
            return 'Se cumplen todos los requisitos.';
        } else {
            return join(', ', $res);
        }
    }
    
    public function getEstadoNombre() {
        switch($this->Estado) {
            case 0: return 'Nuevo';
            case 10: return 'Iniciado';
            case 90: return 'Cancelado';
            case 100: return 'Terminado';
            default: return '???';
        }
    }
    
    public function AgregarEstadoRequisito($EstadoNuevo) {
        $this->EstadoRequisitos[] = $EstadoNuevo;
    }




    public function getEstado() {
        return $this->Estado;
    }

    public function setEstado($Estado) {
        $this->Estado = $Estado;
    }
    
    public function getEstadosRequisitos() {
        return $this->EstadosRequisitos;
    }

    public function setEstadosRequisitos($EstadosRequisitos) {
        $this->EstadosRequisitos = $EstadosRequisitos;
    }
    
    public function getTramiteTipo() {
        return $this->TramiteTipo;
    }

    public function setTramiteTipo($TramiteTipo) {
        $this->TramiteTipo = $TramiteTipo;
    }
}
