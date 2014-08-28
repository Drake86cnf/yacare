<?php

namespace Yacare\TramitesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Clase base de un trámite en curso (representa una instancia).
 * 
 * Representa una instancia de un trámite en curso, con su avance y el estado
 * de sus requisitos.
 *
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Table(name="Tramites_Tramite")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="TramiteTipo", type="string")
 * @ORM\DiscriminatorMap({
 *      "\Yacare\ComercioBundle\Entity\TramiteHabilitacionComercial" = "\Yacare\ComercioBundle\Entity\TramiteHabilitacionComercial",
 *      "\Yacare\ObrasParticularesBundle\Entity\TramiteCat" = "\Yacare\ObrasParticularesBundle\Entity\TramiteCat"
 * })
 */
abstract class Tramite
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Tapir\BaseBundle\Entity\ConNombre;
    use \Tapir\BaseBundle\Entity\ConObs;
    use \Tapir\BaseBundle\Entity\Versionable;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;

    use \Yacare\TramitesBundle\Entity\ConTitular;
    
    public function __construct()
    {
        $this->EstadosRequisitos = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * El estado del trámite, desde 0 (nuevo sin iniciar) hasta 100 (terminado).
     * 
     * @see getEstadoNombre()
     * 
     * @ORM\Column(type="integer")
     */
    private $Estado = 0;
    
    /**
     * Indica de qué tipo de trámite se trata (discriminador).
     * 
     * @see TramiteTipo
     * 
     * @ORM\ManyToOne(targetEntity="TramiteTipo")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $TramiteTipo;
    
    /**
     * Colección que contiene los estados de los requisitos asociados a este
     * trámite.
     * 
     * @ORM\OneToMany(targetEntity="EstadoRequisito", mappedBy="Tramite", cascade={"persist"})
     * @ORM\JoinTable(name="Tramites_Tramite_EstadoRequisito",
     *      joinColumns={@ORM\JoinColumn(name="Tramite_id", referencedColumnName="Tramite_id")}
     * )
     */
    private $EstadosRequisitos;
    
    /**
     * Indica la fecha en la que terminó el trámite o null si aun está en curso
     * o nunca terminó (cancelado).
     * 
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $FechaTerminado;
    
    /**
     * El comprobante que se emitió como resultado de este trámite o null si no
     * se emitió ningún comprobante o el trámite aun está en curso.
     * 
     * @ORM\ManyToOne(targetEntity="Comprobante")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $Comprobante;
        
    
    /*
     * Devuelve true si el trámite aun está en curso (no está terminado ni
     * cancelado).
     */
    public function EstaEnCurso() {
        return $this->getEstado() < 90;
    }
    
    /**
     * Devuelve el porcentaje (de 0 a 100) de avance del trámite, calculado
     * según la cantidad de requisitos que están cumplidos y la cantidad que
     * están pendientes.
     * 
     * @return int El porcentaje completado.
     */
    public function PorcentajeCompleto() {
        if ($this->RequisitosObligatoriosCantidad() == 0) {
            return 0;
        } else {
            return round((1 - $this->RequisitosFaltantesCantidad() / $this->RequisitosObligatoriosCantidad()) * 100);
        }
    }
    
    /**
     * Devuelve true si el trámite está listo para ser terminado (es decir,
     * todos los requisitos están cumplidos).
     * 
     * @return bool true si el trámite está listo para ser terminado.
     */
    public function EstaListoParaTerminar() {
        return $this->PorcentajeCompleto() >= 100 && $this->EstaEnCurso();
    }
    
    /**
     * Devuelve true si el trámite está terminado.
     * 
     * @return bool true si está terminado.
     */
    public function EstaTerminado() {
        return $this->getEstado() == 100;
    }
    
    
    /**
     * Devuelve la cantidad total de requisitos obligatorios.
     * 
     * @return int La cantidad total de requisitos obligatorios.
     */
    public function RequisitosObligatoriosCantidad() {
        $res = 0;
        foreach ($this->EstadosRequisitos as $EstadoRequisito) {
            if ($EstadoRequisito->EsNecesario() && $EstadoRequisito->EsOpcional() == false) {
                $res++;
            }
        }
        return $res;
    }
    
    
    /**
     * Devuelve la cantidad de requisitos obligatorios faltantes.
     * 
     * @return int La cantidad de requisitos obligatorios que aun no fueron
     * cumplidos.
     */
    public function RequisitosFaltantesCantidad() {
        $res = 0;
        foreach ($this->EstadosRequisitos as $EstadoRequisito) {
            if ($EstadoRequisito->EsNecesario() && $EstadoRequisito->EsOpcional() == false && $EstadoRequisito->EstaCumplido() == false) {
                $res++;
            }
        }
        return $res;
    }
    
    
    /**
     * Devuelve una cadena que explica el estado de los requisitos (por ejemplo
     * una lista de los requisitos faltantes o un texto que indique que todos
     * los requisitos están cumplidos.
     *
     * @return string Cadena que explica el estado de los requisitos
     */
    public function ExplicarEstadosRequisitos() {
        $res = array();
        foreach ($this->EstadosRequisitos as $EstadoRequisito) {
            if ($EstadoRequisito->EsNecesario() && $EstadoRequisito->EstaCumplido() == false) {
                $res[] = 'Falta ' . (string)$EstadoRequisito;
            }
        }
        
        if (count($res) == 0) {
            return 'Se cumplen todos los requisitos.';
        } else {
            return join(', ', $res);
        }
    }
    
    /**
     * Devuelve el estado en forma de texto.
     * 
     * @return string El texto que representa al estado del trámite.
     */
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
        $this->EstadosRequisitos[] = $EstadoNuevo;
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
    
    public function getFechaTerminado() {
        return $this->FechaTerminado;
    }

    public function setFechaTerminado(\DateTime $FechaTerminado) {
        $this->FechaTerminado = $FechaTerminado;
    }
    
    public function getComprobante() {
        return $this->Comprobante;
    }

    public function setComprobante($Comprobante) {
        $this->Comprobante = $Comprobante;
    }
}
