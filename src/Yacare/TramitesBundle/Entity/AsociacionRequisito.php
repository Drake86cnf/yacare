<?php
/*
 * Representa la asociación de un requisito con un TramiteTipo
 */
namespace Yacare\TramitesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Asociación de un requisito con un trámite.
 *
 * Representa la asociación entre un requisito y un trámite, y las condiciones
 * bajos las cuales están asociados.
 *
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Table(name="Tramites_TramiteTipo_Requisito")
 */
class AsociacionRequisito
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Tapir\BaseBundle\Entity\ConObs;
    use \Tapir\BaseBundle\Entity\ConNotas;
    use \Tapir\BaseBundle\Entity\Eliminable;
    
    /**
     * El tipo de trámite.
     *
     * @var \Yacare\TramitesBundle\Entity\TramiteTipo
     * 
     * @see \Yacare\TramitesBundle\Entity\TramiteTipo TramiteTipo 
     * 
     * @ORM\ManyToOne(targetEntity="TramiteTipo", inversedBy="AsociacionRequisitos")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $TramiteTipo;
    
    /**
     * @var string 
     * 
     * @ORM\Column(type="string", nullable=true)
     */
    private $Propiedad;
    
    /**
     * El requisito.
     * 
     * @var \Yacare\TramitesBundle\Entity\Requisito
     * 
     * @see \Yacare\TramitesBundle\Entity\Requisito Requisito 
     * 
     * @ORM\ManyToOne(targetEntity="Requisito")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $Requisito;
    
    /**
     * La instancia del requisito (original, copia, etc.)
     *
     * @var string 
     * 
     * @ORM\Column(type="string", nullable=true)
     */
    private $Instancia;
    
    /**
     * Tipo de asociación (0 = regular, 1 = opcional, 2 = condicional).
     * 
     * Si el requisito es opcional, indica que se puede completar el trámite aunque el requisito,
     * no haya sido cumplido. Si es condicional, siginifica que se debe completar sólo si se
     * evalúa la condición, y si es regular significa que se debe completar siempre.
     *
     * @var int
     * 
     * @ORM\Column(type="integer", nullable=false)
     */
    private $Tipo = 0;
    
    /**
     * El "qué" de la condición.
     *
     * * Por ejemplo, en la condición "categoría > 3", la categoría es el "qué",
     * ">" es el "es" y 3 es el "cuánto".
     *
     * @var string 
     * 
     * @see $CondicionEs $CondicionEs
     * @see $CondicionCuanto $CondicionCuanto
     * 
     * @ORM\Column(type="string", nullable=true)
     */
    private $CondicionQue;
    
    /**
     * El "es" de la condición.
     *
     * * Por ejemplo, en la condición "categoría > 3", la categoría es el "qué",
     * ">" es el "es" y 3 es el "cuánto".
     *
     * @var string
     * 
     * @see $CondicionQue $CondicionQue
     * @see $CondicionCuanto $CondicionCuanto
     * 
     * @ORM\Column(type="string", nullable=true)
     */
    private $CondicionEs;
    
    /**
     * El "cuánto" de la condición.
     *
     * * Por ejemplo, en la condición "categoría > 3", la "categoría" es el "qué",
     * ">" es el "es" y "3" es el "cuánto".
     *
     * @var string
     * 
     * @see $CondicionQue $CondicionQue
     * @see $CondicionEs $CondicionEs 
     * 
     * @ORM\Column(type="string", nullable=true)
     */
    private $CondicionCuanto;
    
    /**
     * La etapa a la cual pertenece el requisito, o null si es un trámite sin etapas.
     * 
     * @var string
     * 
     * @ORM\Column(type="string", nullable=true)
     */
    private $Etapa;
    
    /**
     * Requisitos que se solicitan al momento de iniciar un tramite.
     *
     * @var boolean
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $RequeridoAlIniciar;

    /**
     * Devuelve true si esta asociación es opcional (Tipo = 1).
     * 
     * @return boolean
     */
    public function EsOpcional()
    {
        return ($this->getTipo() & 1) == 1;
    }

    /**
     * Devuelve true si esta asociación es condicional (Tipo = 2).
     * 
     * @return boolean
     */
    public function EsCondicional()
    {
        return ($this->getTipo() & 2) == 2;
    }

    /**
     * Devuelve una representación de cadena del valor Propiedad.
     * 
     * @see $Propiedad
     */
    public function getPropiedadNombre()
    {
        $Partes = array_reverse(explode('.', $this->getPropiedad()));
        return join(' de ', $Partes);
    }

    /**
     * Devuelve una representación de cadena del valor Instancia.
     *
     * @see $Instancia
     *
     * @return string
     */
    public function getInstanciaNombre()
    {
        switch ($this->getInstancia()) {
            case 'na':
                return 'n/a';
            case 'ori':
                return 'Original';
            case 'cop':
                return 'Original y copia';
            case 'cos':
                return 'Copia simple';
            case 'coc':
                return 'Copia certificada';
            case 'col':
                return 'Copia legalizada';
        }
    }

    /**
     * Devuelve una representación de cadena de la condición.
     *
     * @see $CondicionQue
     * @see $CondicionEs
     * @see $CondicionCuanto
     *
     * @return type
     */
    public function getCondicion()
    {
        if ($this->getObs()) {
            return $this->getObs();
        }
        
        // return $res = '';
        $res = '';
        if ($this->CondicionQue) {
            switch ($this->CondicionEs) {
                case 'notnull':
                    $res .= 'hay ';
                    break;
            }
            $Partes = explode('.', $this->CondicionQue);
            $res .= join(' de ', array_reverse($Partes));
            
            switch ($this->CondicionEs) {
                case '==':
                    $res .= ' es igual a ';
                    break;
                case '!=':
                    $res .= ' no es igual a ';
                    break;
                case '>':
                    $res .= ' es mayor que ';
                    break;
                case '<':
                    $res .= ' es menor que ';
                    break;
                case '>=':
                    $res .= ' es mayor o igual que ';
                    break;
                case '<=':
                    $res .= ' es menor o igual que ';
                    break;
                case 'null':
                    $res .= ' es nulo';
                    break;
                case 'not null':
                    $res .= '';
                    break;
                case 'true':
                    // $res .= ' es verdadero';
                    break;
                case 'false':
                    $res .= ' es falso';
                    break;
                case 'in':
                    $res .= ' incluido en';
                    break;
                case 'not in':
                    $res .= ' no incluido en';
                    break;
                default:
                    $res .= ' ' . $this->CondicionEs . ' ';
                    break;
            }
            if ($this->CondicionCuanto) {
                $res .= ' ' . $this->CondicionCuanto;
            }
        }
        
        return trim($res);
    }

    public function __toString()
    {
        if ($this->getInstancia() && $this->getInstancia() !== 'na') {
            $res = $this->getInstanciaNombre() . ' de ' . (string) ($this->Requisito);
        } else {
            $res = (string) ($this->Requisito);
        }
        
        if ($this->getPropiedad()) {
            $res .= ' de ' . $this->getPropiedad();
        }
        
        return $res;
    }

    /**
     * @ignore
     */
    public function getRequisito()
    {
        return $this->Requisito;
    }

    /**
     * @ignore
     */
    public function setRequisito($Requisito)
    {
        $this->Requisito = $Requisito;
    }

    /**
     * @ignore
     */
    public function getCondicionQue()
    {
        return $this->CondicionQue;
    }

    /**
     * @ignore
     */
    public function setCondicionQue($CondicionQue)
    {
        $this->CondicionQue = $CondicionQue;
    }

    /**
     * @ignore
     */
    public function getCondicionEs()
    {
        return $this->CondicionEs;
    }

    /**
     * @ignore
     */
    public function setCondicionEs($CondicionEs)
    {
        $this->CondicionEs = $CondicionEs;
    }

    /**
     * @ignore
     */
    public function getCondicionCuanto()
    {
        return $this->CondicionCuanto;
    }

    /**
     * @ignore
     */
    public function setCondicionCuanto($CondicionCuanto)
    {
        $this->CondicionCuanto = $CondicionCuanto;
    }

    /**
     * @ignore
     */
    public function getPropiedad()
    {
        return $this->Propiedad;
    }

    /**
     * @ignore
     */
    public function setPropiedad($Propiedad)
    {
        $this->Propiedad = $Propiedad;
    }

    /**
     * @ignore
     */
    public function getInstancia()
    {
        return $this->Instancia;
    }

    /**
     * @ignore
     */
    public function setInstancia($Instancia)
    {
        $this->Instancia = $Instancia;
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
    public function getTipo()
    {
        return $this->Tipo;
    }

    /**
     * @ignore
     */
    public function setTipo($Tipo)
    {
        $this->Tipo = $Tipo;
        return $this;
    }

    /**
     * @ignore
     */
    public function getEtapa()
    {
        return $this->Etapa;
    }

    /**
     * @ignore
     */
    public function setEtapa($Etapa)
    {
        $this->Etapa = $Etapa;
        return $this;
    }

    /**
     * @ignore
     */
    public function getRequeridoAlIniciar()
    {
        return $this->RequeridoAlIniciar;
    }

    /**
     * @ignore
     */
    public function setRequeridoAlIniciar($RequeridoAlIniciar)
    {
        $this->RequeridoAlIniciar = $RequeridoAlIniciar;
        return $this;
    }
 

}
