<?php

namespace Yacare\TramitesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\TramitesBundle\Entity\TramiteTipoRequisito
 *
 * @ORM\Entity
 * @ORM\Table(name="Tramites_TramiteTipoRequisito")
 */
class TramiteTipoRequisito
{
    use \Yacare\BaseBundle\Entity\ConId;
    use \Yacare\BaseBundle\Entity\ConObs;
    use \Yacare\BaseBundle\Entity\Eliminable;

    /**
     * @ORM\ManyToOne(targetEntity="TramiteTipo")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $TramitePadre;

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
            case 'org':
                return 'Original';
            case 'cop':
                return 'Copia';
       }
    }

    
    public function getCondicion() {
        $res = '';
        if($this->CondicionQue) {
            $res .= $this->CondicionQue;
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
                    $res .= ' no existe';
                    break;
                case 'notnull';
                    $res .= ' existe';
                    break;
                case 'true';
                    $res .= ' es verdadero';
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
            if($this->CondicionCuanto)
                $res .= ' ' . $this->CondicionCuanto;
        }
        
        return $res;
    }

    public function __toString() {
        return (string)($this->Requisito);
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
    
    public function getTramitePadre() {
        return $this->TramitePadre;
    }

    public function setTramitePadre($TramitePadre) {
        $this->TramitePadre = $TramitePadre;
    }
}
