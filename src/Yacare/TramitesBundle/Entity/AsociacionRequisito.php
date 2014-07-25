<?php
/*
 * Representa la asociación de un requisito con un TramiteTipo
 */
namespace Yacare\TramitesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Asociación de un requisito con un trámite.
 * 
 * Representa la asociación entre un requisito y un trámite, y sus condiciones.
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
     * @ORM\ManyToOne(targetEntity="TramiteTipo", inversedBy="AsociacionRequisitos")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $TramiteTipo;

    /**
     * @var string
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $Propiedad;

    /**
     * @ORM\ManyToOne(targetEntity="Requisito")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $Requisito;
    
    /**
     * @var string
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $Instancia;
    
    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     */
    private $Opcional;
    
    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $CondicionQue;
    
    /**
     * @var string
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $CondicionEs;
    
    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $CondicionCuanto;
    

    public function getInstanciaNombre() {
        switch($this->getInstancia()) {
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

    
    public function getCondicion() {
        if ($this->getObs()) {
            return $this->getObs();
        }
        
        return $res = '';
        if ($this->CondicionQue) {
            switch($this->CondicionEs) {
                case 'notnull';
                    $res .= 'hay ';
                    break;
            }
            $Partes = explode('.', $this->CondicionQue);
            $res .= join(' de ', array_reverse($Partes));
           
            switch($this->CondicionEs) {
                case '==';
                    $res .= ' es igual a ';
                    break;
                case '!=';
                    $res .= ' no es igual a ';
                    break;
                case '>';
                    $res .= ' es mayor que ';
                    break;
                case '<';
                    $res .= ' es menor que ';
                    break;
                case '>=';
                    $res .= ' es mayor o igual que ';
                    break;
                case '<=';
                    $res .= ' es menor o igual que ';
                    break;
                case 'null';
                    $res .= ' es nulo';
                    break;
                case 'notnull';
                    $res .= '';
                    break;
                case 'true';
                    //$res .= ' es verdadero';
                    break;
                case 'false';
                    $res .= ' es falso';
                    break;
                case 'in';
                    $res .= ' incluido en';
                    break;
                case 'notint';
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

    public function __toString() {
        if ($this->getInstancia() && $this->getInstancia() !== 'na') {
            $res = $this->getInstanciaNombre() . ' de ' . (string)($this->Requisito);
        } else {
            $res = (string)($this->Requisito);
        }
        
        if ($this->getPropiedad()) {
             $res .= ' de ' . $this->getPropiedad();
        }
        
        return $res;
    }
    
    
    public function getRequisito() {
        return $this->Requisito;
    }

    public function setRequisito($Requisito) {
        $this->Requisito = $Requisito;
    }

    public function getCondicionQue() {
        return $this->CondicionQue;
    }

    public function setCondicionQue($CondicionQue) {
        $this->CondicionQue = $CondicionQue;
    }

    public function getCondicionEs() {
        return $this->CondicionEs;
    }

    public function setCondicionEs($CondicionEs) {
        $this->CondicionEs = $CondicionEs;
    }

    public function getCondicionCuanto() {
        return $this->CondicionCuanto;
    }

    public function setCondicionCuanto($CondicionCuanto) {
        $this->CondicionCuanto = $CondicionCuanto;
    }

    public function getOpcional() {
        return $this->Opcional;
    }

    public function setOpcional($Opcional) {
        $this->Opcional = $Opcional;
    }
    
    public function getPropiedad() {
        return $this->Propiedad;
    }

    public function setPropiedad($Propiedad) {
        $this->Propiedad = $Propiedad;
    }
    public function getInstancia() {
        return $this->Instancia;
    }

    public function setInstancia($Instancia) {
        $this->Instancia = $Instancia;
    }
    
    public function getTramiteTipo() {
        return $this->TramiteTipo;
    }

    public function setTramiteTipo($TramiteTipo) {
        $this->TramiteTipo = $TramiteTipo;
    }
}
