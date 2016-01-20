<?php
namespace Yacare\TramitesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Clase base de un trámite en curso (representa una instancia).
 *
 * Representa una instancia de un trámite en curso, con su avance y el estado
 * de sus requisitos.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 *
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Table(name="Tramites_Tramite")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="TramiteTipoClase", type="string")
 * @ORM\DiscriminatorMap({
 *   "\Yacare\TramitesBundle\Entity\TramiteSimple" = "\Yacare\TramitesBundle\Entity\TramiteSimple",
 *   "\Yacare\ComercioBundle\Entity\TramiteHabilitacionComercial" = "\Yacare\ComercioBundle\Entity\TramiteHabilitacionComercial",
 *   "\Yacare\ObrasParticularesBundle\Entity\TramiteCat" = "\Yacare\ObrasParticularesBundle\Entity\TramiteCat",
 *   "\Yacare\ObrasParticularesBundle\Entity\TramitePlano" = "\Yacare\ObrasParticularesBundle\Entity\TramitePlano"
 * })
 */
abstract class Tramite implements ITramite
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Tapir\BaseBundle\Entity\ConNombre;
    use \Tapir\BaseBundle\Entity\ConObs;
    use \Tapir\BaseBundle\Entity\Versionable;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    use \Yacare\TramitesBundle\Entity\ConTitular;
    use \Yacare\BaseBundle\Entity\ConAdjuntos;

    public function __construct()
    {
        $this->EstadosRequisitos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->Nombre = 'Nuevo ' . get_class($this);
    }

    /**
     * El estado del trámite, desde 0 (nuevo sin iniciar) hasta 100 (terminado).
     *
     * @see getEstadoNombre() getEstadoNombre()
     *
     * @ORM\Column(type="integer")
     */
    protected $Estado = 0;

    /**
     * Indica de qué tipo de trámite se trata (discriminador).
     *
     * @var \Yacare\TramitesBundle\Entity\TramiteTipo
     *
     * @see \Yacare\TramitesBundle\Entity\TramiteTipo TramiteTipo
     *
     * @ORM\ManyToOne(targetEntity="TramiteTipo")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $TramiteTipo;
    
    /**
     * El trámite padre, en caso de que este trámite se haya disparado como sub-trámite de otro.
     *
     * @var \Yacare\TramitesBundle\Entity\Tramite
     * @see \Yacare\TramitesBundle\Entity\Tramite
     *
     * @ORM\ManyToOne(targetEntity="Tramite")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $TramitePadre;

    /**
     * Colección que contiene los estados de los requisitos asociados a este
     * trámite.
     *
     * @var \Yacare\TramitesBundle\Entity\EstadoRequisito
     *
     * @ORM\OneToMany(targetEntity="EstadoRequisito", mappedBy="Tramite", cascade={"persist"})
     * @ORM\JoinTable(name="Tramites_Tramite_EstadoRequisito",
     *     joinColumns={@ORM\JoinColumn(name="Tramite_id", referencedColumnName="Tramite_id")}
     * )
     * 
     * @JMS\Serializer\Annotation\Exclude
     */
    protected $EstadosRequisitos;

    /**
     * Indica la fecha en la que terminó el trámite o null si aun está en curso
     * o nunca terminó (cancelado).
     *
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $FechaTerminado;

    /**
     * El comprobante que se emitió como resultado intermedio de este trámite o null si no
     * se emitió ningún comprobante o el trámite aun está en curso.
     *
     * @var \Yacare\TramitesBundle\Enitty\Comprobante Comprobante
     *
     * @ORM\ManyToOne(targetEntity="Comprobante")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $ComprobanteIntermedio;
    
    /**
     * El comprobante que se emitió como resultado de este trámite o null si no
     * se emitió ningún comprobante o el trámite aun está en curso.
     *
     * @var \Yacare\TramitesBundle\Enitty\Comprobante Comprobante
     *
     * @ORM\ManyToOne(targetEntity="Comprobante")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $Comprobante;    
    
    /**
     * Devuelve un colección de los actores que intervienen en este trámite, y el nombre de la propiedad
     * que refleja a cada uno.
     */
    public function Actores() {
        return array(
            'Titular' => 'Titular'
        );
    }    
    
    public function ObtenerActor($actorPropiedad) {
        $Propiedades = explode('.', $actorPropiedad);
        $ValorQue = null;
        $Objeto = $this;
        foreach ($Propiedades as $Propiedad) {
            if(strstr($Propiedad, '(') !== false) {
                $Parametro = trim(strstr($Propiedad, '('), '()');
                $Propiedad = strstr($Propiedad, '(', true);
            } else {
                $Parametro = null;
            }
        
            if (method_exists($Objeto, $Propiedad)) {
                $Callable = array($Objeto, $Propiedad);
            } elseif (method_exists($Objeto, 'get' . $Propiedad)) {
                $Callable = array($Objeto, 'get' . $Propiedad);
            } else {
                $Callable = array($Objeto, 'get' . $Propiedad);
            }
        
            if (is_callable($Callable)) {
                if($Parametro) {
                    $ValorQue = call_user_func($Callable, $Parametro);
                } else {
                    $ValorQue = call_user_func($Callable);
                }
                $Objeto = $ValorQue;
            } else {
                $ValorQue = null;
                break;
            }
        }        
        return $ValorQue;
    }
    
    
    /**
     * Busca si un requisito de este trámite es un subtrámite, y devuelve el EstadoRequisito asociado.
     * 
     * @param \Yacare\TramitesBundle\Entity\Tramite $tramite
     * @return \Yacare\TramitesBundle\Entity\EstadoRequisito
     */
    public function ObtenerEstadoRequisitoPorSubTramite($subtramite) {
        foreach($this->getEstadosRequisitos() as $EstadoRequisito) {
            if($EstadoRequisito->getAsociacionRequisito()->getRequisito()->getTipo() == 'tra'
                && ($EstadoRequisito->getAsociacionRequisito()->getRequisito()->getTramiteTipoEspejo()->getId()
                    == $subtramite->getTramiteTipo()->getId())) {
                    return $EstadoRequisito;
                }
        }
    }
    
    
    /**
     * Obtiene la asociación de requisito, en caso de que este trámite es parte de otro trámite.
     */
    public function ObtenerEstadoRequisito() {
        $TramPadre = $this->getTramitePadre();
        if($TramPadre) {
            foreach($TramPadre->getEstadosRequisitos() as $EstadoRequisito) {
                if($EstadoRequisito->getTramite() == $this) {
                    return $EstadoRequisito;
                }
            }
            return null;
        } else {
            return null;
        }
    }

    /**
     * Devuelve true si el trámite aun está en curso (no está terminado ni cancelado).
     *
     * @return boolean
     */
    public function EstaEnCurso()
    {
        return $this->getEstado() < 90;
    }

    /**
     * Devuelve el porcentaje (de 0 a 100) de avance del trámite, calculado
     * según la cantidad de requisitos que están cumplidos y la cantidad que
     * están pendientes.
     *
     * @return int El porcentaje completado.
     */
    public function PorcentajeCompleto()
    {
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
    public function EstaListoParaTerminar()
    {
        return $this->PorcentajeCompleto() >= 100 && $this->EstaEnCurso();
    }
    
    /**
     * Devuelve true si el trámite está listo para ser pasar a estado intermedio (es decir,
     * todos los requisitos intermedios están cumplidos).
     *
     * @return bool true si el trámite está listo para pasar a estado intermedio.
     */
    public function EstaListoParaIntermedio()
    {
        // TODO:
        return false; 
    }
    
    /**
     * Devuelve una lista de razones por las que no se puede terminar, sin contar los requisitos.
     * 
     * @see EsViable()
     * @return string[] La lista.
     */
    public function QueImpideTerminar() {
        $res = array();
        if($this->EstaEnCurso() == false) {
            $res[] = 'El trámite no está en curso.';
        }    
        return $res;
    }
    
    /**
     * Devuelve true si el trámite se puede completar cuando estén todos los requisitos cumplidos.
     * 
     * El trámite puede tener condiciones adicionales a los requisitos. Esta función devuelve si estas
     * condiciones se cumplen.
     * 
     * @see QueImpideTerminar()
     * @return boolean
     */
    public function EsViable() {
        return count($this->QueImpideTerminar()) == 0;
    }
    

    /**
     * Devuelve true si el trámite está terminado.
     *
     * @return bool true si está terminado.
     */
    public function EstaTerminado()
    {
        return $this->getEstado() == 100;
    }
    
    
    /**
     * Devuelve true si el trámite está en estado intermedio.
     *
     * @return bool true si está en estado intermedio.
     */
    public function EstaIntermedio()
    {
        return $this->getEstado() == 80;
    }
    

    /**
     * Devuelve la cantidad total de requisitos obligatorios.
     *
     * @return int La cantidad total de requisitos obligatorios.
     */
    public function RequisitosObligatoriosCantidad()
    {
        $res = 0;
        foreach ($this->EstadosRequisitos as $EstadoRequisito) {
            if ($EstadoRequisito->EsNecesario() && $EstadoRequisito->EsOpcional() == false) {
                $res ++;
            }
        }
        return $res;
    }

    /**
     * Devuelve la cantidad de requisitos obligatorios faltantes.
     *
     * @return int La cantidad de requisitos obligatorios que aun no fueron
     *             cumplidos.
     */
    public function RequisitosFaltantesCantidad()
    {
        $res = 0;
        foreach ($this->EstadosRequisitos as $EstadoRequisito) {
            if ($EstadoRequisito->EsNecesario() && $EstadoRequisito->EsOpcional() == false &&
                 $EstadoRequisito->EstaCumplido() == false) {
                $res ++;
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
    public function ExplicarEstadosRequisitos()
    {
        $res = array();
        foreach ($this->EstadosRequisitos as $EstadoRequisito) {
            if ($EstadoRequisito->EsNecesario() && $EstadoRequisito->EstaCumplido() == false) {
                $res[] = 'Falta ' . (string) $EstadoRequisito;
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
    public function getEstadoNombre()
    {
        return self::NombreEstado($this->Estado);
    }
    
    /**
     * Devuelve nombres de estado normalizados.
     *
     * @param  integer $estado
     * @return string
     */
    public static function NombreEstado($estado)
    {
        return Tramite::NombresEstados()[$estado];
    }
    
    /**
     * Devuelve un array con los posibles estados y sus nombres.
     */
    public static function NombresEstados() {
        return array(
            0 => 'Nuevo',
            10 => 'Iniciado',
            80 => 'Intermedio',
            90 => 'Cancelado',
            100 => 'Terminado'
        );
    }
    
    /**
     * @ignore
     */
    public function AgregarEstadoRequisito($EstadoNuevo)
    {
        $this->EstadosRequisitos[] = $EstadoNuevo;
    }

    /**
     * @ignore
     */
    public function getEstado()
    {
        return $this->Estado;
    }

    /**
     * @ignore
     */
    public function setEstado($Estado)
    {
        $this->Estado = $Estado;
    }

    /**
     * @ignore
     */
    public function getEstadosRequisitos()
    {
        return $this->EstadosRequisitos;
    }

    /**
     * @ignore
     */
    public function setEstadosRequisitos($EstadosRequisitos)
    {
        $this->EstadosRequisitos = $EstadosRequisitos;
    }

    /**
     * @ignore
     */
    public function getTramiteTipo()
    {
        return $this->TramiteTipo;
    }

    /**
     * @ignore
     */
    public function setTramiteTipo($TramiteTipo)
    {
        $this->TramiteTipo = $TramiteTipo;
    }

    /**
     * @ignore
     */
    public function getFechaTerminado()
    {
        return $this->FechaTerminado;
    }

    /**
     * @ignore
     */
    public function setFechaTerminado(\DateTime $FechaTerminado)
    {
        $this->FechaTerminado = $FechaTerminado;
    }

    /**
     * @ignore
     */
    public function getComprobante()
    {
        return $this->Comprobante;
    }

    /**
     * @ignore
     */
    public function setComprobante($Comprobante)
    {
        $this->Comprobante = $Comprobante;
    }

    /**
     * @ignore
     */
    public function getTramitePadre()
    {
        return $this->TramitePadre;
    }

    /**
     * @ignore
     */
    public function setTramitePadre($TramitePadre)
    {
        $this->TramitePadre = $TramitePadre;
        return $this;
    }

    /**
     * @ignore
     */
    public function getComprobanteIntermedio()
    {
        return $this->ComprobanteIntermedio;
    }

    /**
     * @ignore
     */
    public function setComprobanteIntermedio($ComprobanteIntermedio)
    {
        $this->ComprobanteIntermedio = $ComprobanteIntermedio;
        return $this;
    }
 
}
