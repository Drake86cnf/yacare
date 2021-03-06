<?php
/*
 * Representa el estado de un requisito dentro de un trámite.
 */
namespace Yacare\TramitesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Estado de un requisito de un trámite.
 *
 * Define el estado en el que se encuentra un requisito asociado a un trámite
 * en curso.
 *
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Table(name="Tramites_EstadoRequisito", uniqueConstraints={
 *     @ORM\UniqueConstraint(name="TramiteAsociacionRequisito", columns={"Tramite_id", "AsociacionRequisito_id"})},
 *     indexes={@ORM\Index(name="Tramites_EstadoRequisito_Tramite", columns={"Tramite_id"})}
 * )
 */
class EstadoRequisito implements IEstadoRequisito
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Tapir\BaseBundle\Entity\ConObs;
    use \Yacare\BaseBundle\Entity\ConFechaValidezHasta;
    
    public function __construct()
    {
        $this->Adjuntos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * El trámite al cual está asociado este requisito.
     *
     * @var \Yacare\TramitesBundle\Entity\Tramite
     *
     * @see \Yacare\TramitesBundle\Entity\Tramite Tramite
     *
     * @ORM\ManyToOne(targetEntity="Tramite", inversedBy="EstadosRequisitos")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $Tramite;
    
    /**
     * Si este requisito es tipo trámite, esta propiedad apunta al subtrámite. 
     *
     * @var \Yacare\TramitesBundle\Entity\Tramite
     * @see \Yacare\TramitesBundle\Entity\Tramite Tramite
     *
     * @ORM\ManyToOne(targetEntity="Tramite")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $Subtramite;

    /**
     * La asociación entre el trámite y el requisito, que también describe las
     * condiciones en las que está asociado.
     *
     * @var \Yacare\TramitesBundle\Entity\AsociacionRequisito
     *
     * @ORM\ManyToOne(targetEntity="AsociacionRequisito")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $AsociacionRequisito;
    
    /**
     * Los adjuntos asociado con este requisito.
     *
     * @var \Yacare\BaseBundle\Entity\Adjunto
     *
     * @ORM\ManyToMany(targetEntity="Yacare\BaseBundle\Entity\Adjunto")
     */
    protected $Adjuntos;

    /**
     * El requisito padre, en caso de que este no sea un requisito directo, sino
     * sino un sub requisto (requisito de un requisito).
     *
     * @ORM\ManyToOne(targetEntity="EstadoRequisito")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $EstadoRequisitoPadre;

    /**
     * El estado de este requisito para el trámite asociado.
     *
     * @var integer
     *
     * @ORM\Column(type="integer")
     */
    protected $Estado = 0;

    /**
     * La fecha en la cual el requisito fue aprobado, o null si aun no lo fue.
     *
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $FechaAprobado;

    /**
     * Devuelve true si este requisito es necesario para este trámite.
     *
     * Los requisitos pueden ser opcionales o pueden ser solicitados en base a
     * condiciones (por ejemplo sólo para personas jurídicas o sólo para
     * inmuebles mayores a 100 m2).
     * Este método devuelve true si este requisito debe solicitarse este
     * trámite en particular.
     *
     * @return boolean Devuelve true si este requisito es necesario.
     *
     * @see $Tramite $Tramite
     */
    public function EsNecesario()
    {
        if ($this->getEstadoRequisitoPadre()) {
            // Es un sub-requisito. Evaluo también si el parent es necesario.
            return $this->CondicionSeCumple() && $this->getEstadoRequisitoPadre()->EsNecesario();
        } else {
            return $this->CondicionSeCumple();
        }
    }

    /**
     * Devuelve true si el requisito es opcional o si este es un sub requisito
     * de un requisito opcional.
     *
     * @return bool Devuelve true si el requisito es opcional.
     */
    public function EsOpcional()
    {
        if ($this->getEstadoRequisitoPadre()) {
            // Es un sub-requisito. Evaluo también si el parent es opcional.
            return $this->getAsociacionRequisito()->EsOpcional() || $this->getEstadoRequisitoPadre()->EsOpcional();
        } else {
            return $this->getAsociacionRequisito()->EsOpcional();
        }
    }

    /**
     * Devuelve true si el requisito asociado se da por cumplido.
     *
     * Para los requisitos opcionales, siempre devuelve true.
     *
     * @return bool Devuelve true si el requisito se da por cumplido.
     *
     * @see $AsociacionRequisito $AsociacionRequisito
     */
    public function EstaCumplido()
    {
        return $this->EsNecesario() == false || $this->EsOpcional() || $this->getEstado() >= 99;
    }
    
    /**
     * Devuelve true si se cumple la condición en la cual debe solicitarse el
     * requisito asociado.
     *
     * @return boolean
     *
     * @see $AsociacionRequisito $AsociacionRequisito
     */
    public function CondicionSeCumple()
    {
        $Asoc = $this->getAsociacionRequisito();

        if ( $Asoc->EsCondicional() == false ) {
            // No hay condición... lo doy siempre por cumplido
            return true;
        }

        /*
         * Busco recursivamente las propiedades. Por ejemplo, "Titular.NumeroDocumento" se convierte en
         * "$this->getTramite()->getTitular()->getNumeroDocumento()"
         */

        $Objeto = $this->getTramite();
        $Propiedades = explode('.', $Asoc->getCondicionQue());
        $ValorQue = null;
        foreach ($Propiedades as $Propiedad) {
            $ValorCuanto = $Asoc->getCondicionCuanto();
            //echo '->' . $Propiedad . '';
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
                //echo '()';
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
        
        //echo $Asoc->getCondicionQue() . '(' . $ValorQue . ') ' . $Asoc->getCondicionEs() . ' ' . $ValorCuanto; 

        switch ($Asoc->getCondicionEs()) {
            case '==':
                return $ValorQue == $ValorCuanto;
            case '!=':
                return $ValorQue != $ValorCuanto;
            case '>':
                return $ValorQue > $ValorCuanto;
            case '>=':
                return $ValorQue >= $ValorCuanto;
            case '<':
                return $ValorQue < $ValorCuanto;
            case '<=':
                return $ValorQue <= $ValorCuanto;
            case 'null':
                return $ValorQue == null;
            case 'not null':
                return $ValorQue != null;
            case 'in':
                return in_array($ValorQue, explode(',', $ValorCuanto));
            case 'not in':
                return !in_array($ValorQue, explode(',', $ValorCuanto));
            case 'true':
                return (bool) $ValorQue;
            case 'false':
                return ! ((bool) $ValorQue);
        }
        return false;
    }
    
    
    /**
     * Devuelve una cadena explicando la expresión que se evalúa para saber si la condición se cumple.
     */
    public function ExplicarCondicion() {
        $Asoc = $this->getAsociacionRequisito();
        
        if ( $Asoc->EsCondicional() == false ) {
            // No hay condición... lo doy siempre por cumplido
            return 'Siempre';
        }
        
        /*
         * Busco recursivamente las propiedades. Por ejemplo, "Titular.NumeroDocumento" se convierte en
         * "$this->getTramite()->getTitular()->getNumeroDocumento()"
         */
        
        $Objeto = $this->getTramite();
        $Propiedades = explode('.', $Asoc->getCondicionQue());
        $ValorQue = null;
        foreach ($Propiedades as $Propiedad) {
            $ValorCuanto = $Asoc->getCondicionCuanto();
            //echo '->' . $Propiedad . '';
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
                //echo '()';
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
        
        $res = 'Si ' . $Asoc->getCondicionQue() . ' (que actualmente vale ' . $ValorQue . ') ' . $Asoc->getCondicionEs() . ' ' . $ValorCuanto;
        
        if ($this->getEstadoRequisitoPadre()) {
            $res .= ' y ' . $this->getEstadoRequisitoPadre()->ExplicarCondicion();
        }
        
        return $res;
    }
    
    

    public function __toString()
    {
        return ((string) $this->getAsociacionRequisito()) . ' en estado ' . $this->getEstadoNombre();
    }

    /**
     * Devuelve un cadena con el nombre del estado del requisito asociado.
     *
     * @param  int $estado El estado del cual solicita el nombre.
     * @return string El nombre del estado.
     */
    public static function EstadoNombres($estado)
    {
        switch ($estado) {
            case 0:
                return 'Faltante';
            case 10:
                return 'Observado';
            case 15:
                return 'Rechazado';
            case 90:
                return 'Desestimado';
            case 95:
                return 'Presentado';
            case 99:
                return 'No es necesario';
            case 100:
                return 'Aprobado';
            default:
                return '???';
        }
    }

    /**
     * Devuelve un cadena con el nombre corto del estado del requisito asociado.
     *
     * @param  int $estado El estado del cual solicita el nombre.
     * @return string El nombre corto del estado.
     */
    public static function EstadoNombresCortos($estado)
    {
        switch ($estado) {
            case 0:
                return 'Faltante';
            case 10:
                return 'Observado';
            case 15:
                return 'Rechazado';
            case 90:
                return 'Desestimado';
            case 95:
                return 'Presentado';
            case 99:
                return 'No necesario';
            case 100:
                return 'Aprobado';
            default:
                return '???';
        }
    }

    /**
     * Devuelve el nombre de estado (normalizado).
     *
     * @return string
     */
    public function getEstadoNombre()
    {
        return EstadoRequisito::EstadoNombres($this->Estado);
    }

    /**
     * Devuelve el nombre corto de estado (normalizado).
     *
     * @return string
     */
    public function getEstadoNombreCorto()
    {
        return EstadoRequisito::EstadoNombresCortos($this->Estado);
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
    public function getTramite()
    {
        return $this->Tramite;
    }

    /**
     * @ignore
     */
    public function setTramite($Tramite)
    {
        $this->Tramite = $Tramite;
    }

    /**
     * @ignore
     */
    public function getAsociacionRequisito()
    {
        return $this->AsociacionRequisito;
    }

    /**
     * @ignore
     */
    public function setAsociacionRequisito($AsociacionRequisito)
    {
        $this->AsociacionRequisito = $AsociacionRequisito;
    }

    /**
     * @ignore
     */
    public function getEstadoRequisitoPadre()
    {
        return $this->EstadoRequisitoPadre;
    }

    /**
     * @ignore
     */
    public function setEstadoRequisitoPadre($EstadoRequisitoPadre)
    {
        $this->EstadoRequisitoPadre = $EstadoRequisitoPadre;
    }

    /**
     * @ignore
     */
    public function getFechaAprobado()
    {
        return $this->FechaAprobado;
    }

    /**
     * @ignore
     */
    public function setFechaAprobado(\DateTime $FechaAprobado)
    {
        $this->FechaAprobado = $FechaAprobado;
    }

    /**
     * @ignore
     */
    public function getAdjuntos()
    {
        return $this->Adjuntos;
    }

    /**
     * @ignore
     */
    public function setAdjuntos($Adjuntos)
    {
        $this->Adjuntos = $Adjuntos;
        return $this;
    }

    /**
     * @ignore
     */
    public function getSubtramite()
    {
        return $this->Subtramite;
    }

    /**
     * @ignore
     */
    public function setSubtramite($Subtramite)
    {
        $this->Subtramite = $Subtramite;
        return $this;
    }
 
 
}
