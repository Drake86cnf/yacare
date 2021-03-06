<?php
namespace Yacare\ComercioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Representa un local donde puede habilitarse un comercio.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 * @author Alejandro Díaz <adiaz.rc@gmail.com>
 *
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Table(name="Comercio_Local")
 */
class Local
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Tapir\BaseBundle\Entity\ConNombre;
    use \Tapir\BaseBundle\Entity\ConObs;
    use \Tapir\BaseBundle\Entity\Suprimible;
    use \Tapir\BaseBundle\Entity\Versionable;
    use \Yacare\CatastroBundle\Entity\ConPartida;
    use \Yacare\BaseBundle\Entity\ConDomicilioLocal;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    
    public function __construct()
    {
        $this->Comercios = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Los comercios que usan o usaron este local.
     *
     * @var Comercio
     *
     * @ORM\OneToMany(targetEntity="Comercio", mappedBy="Local")
     *
     * @JMS\Serializer\Annotation\Exclude
     */
    protected $Comercios;
    
    /**
     * La identificación del local dentro de la partida (en partidas con varios locales, por ejemplo).
     *
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $SubDomicilio;
    
    /**
     * El tipo de local (local, oficina, depósito, etc.).
     *
     * @var string
     * 
     * @ORM\Column(type="string", length=255)
     */
    protected $Tipo = 'Local comercial';
    
    /**
     * La superficie en metros cuadrados.
     *
     * @var float
     * 
     * @ORM\Column(type="float")
     */
    protected $Superficie;
    
    /**
     * La superficie en metros cuadrados dedicada a depósito.
     *
     * @var float
     *
     * @ORM\Column(type="float", nullable=true)
     */
    protected $SuperficieDeposito;
    
    /**
     * La clase de depósito.
     *
     * Sólo aplica si Tipo es "Depósito".
     * 
     * @var DepositoClase
     *
     * @see $Tipo $Tipo
     * 
     * @ORM\ManyToOne(targetEntity="Yacare\ComercioBundle\Entity\DepositoClase")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=true)
     */
    protected $DepositoClase;
    
    /**
     * Indica si el local comercial posee vereda municipal reglamentaria.
     * 
     * @var integer
     *
     * @ORM\Column(type="integer",nullable=true)
     */
    protected $VeredaMunicipal = -1;
    
    /**
     * Indica si el local comercial tiene canaletas reglamentarias.
     * 
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $Canaletas = -1;
    
    /**
     * Indica si el local comercial posee cesto de basura.
     * 
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $CestoBasura = -1;
    
    /**
     * Indica si el local comercial tiene salidas de emergencia.
     * 
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $PuertaEmergencia = -1;
    
    /**
     * Indica la cantidad de anchos de salidas que tiene un local comercial.
     * La unidad de ancho de salida se establece en 0.55m.
     * 
     * @var integer
     * 
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $AnchoSalida = -1;
    
    /**
     * Indica si es o no en parque industrial.
     * 
     * @var boolean
     * 
     * @ORM\Column(type="boolean")
     */
    protected $EnParqueIndustrial = false;

    public function __toString()
    {
        return $this->ConstruirNombre();
    }
    
    
    /**
     * Devuelve el domicilio real o el de la partida si no tiene.
     */
    public function getDomicilioReal() {
        if($this->getDomicilioCalle()) {
            return $this->getDomicilio();
        } else {
            return $this->getPartida()->getDomicilio();
        }
    }
    
    
    /**
     * Intervengo el setter de partida para ponerle un nombre al local.
     */
    public function setPartida($partida) {
        $this->Partida = $partida;
        $this->ConstruirNombre();
    }

    /**
     * Intervengo el setter de nombre para ponerle un nombre al local.
     */
    public function setTipo($Tipo)
    {
        $this->Tipo = $Tipo;
        $this->ConstruirNombre();
    }

    
    /**
     * Establece el nombre que se mostrará.
     * 
     * @return string
     */
    private function ConstruirNombre()
    {
        $res= '';
        if($this->getTipo() != 'Local comercial') {
            $res = $this->getTipo();
        }
        if ($this->getTipo() == 'Depósito' && $this->getDepositoClase()) {
            $res .= ' clase ' . $this->getDepositoClase()->getTipo();
        }
        
        if ($this->getDomicilioCalle()) {
            if($res) {
                $res .= ' en ';
            }
            $res .= $this->getDomicilio();
        } elseif ($this->getPartida()) {
            if($res) {
                $res .= ' en ';
            }
            $res .= $this->getPartida()->getDomicilio();
        }
        if($this->getSubDomicilio()) {
            $res .= ' ' . $this->getSubDomicilio();
        }
        
        $this->setNombre($res);
        
        return $res;
    }
    
    // *** Getters y setters
    
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
    public function getSuperficie()
    {
        return $this->Superficie;
    }

    /**
     * @ignore
     */
    public function setSuperficie($Superficie)
    {
        $this->Superficie = $Superficie;
        return $this;
    }

    /**
     * @ignore
     */
    public function getDepositoClase()
    {
        return $this->DepositoClase;
    }

    /**
     * @ignore
     */
    public function setDepositoClase($DepositoClase)
    {
        $this->DepositoClase = $DepositoClase;
        return $this;
    }

    /**
     * @ignore
     */
    public function getVeredaMunicipal()
    {
        return $this->VeredaMunicipal;
    }

    /**
     * @ignore
     */
    public function setVeredaMunicipal($VeredaMunicipal)
    {
        $this->VeredaMunicipal = $VeredaMunicipal;
        return $this;
    }

    /**
     * @ignore
     */
    public function getCanaletas()
    {
        return $this->Canaletas;
    }

    /**
     * @ignore
     */
    public function setCanaletas($Canaletas)
    {
        $this->Canaletas = $Canaletas;
        return $this;
    }

    /**
     * @ignore
     */
    public function getCestoBasura()
    {
        return $this->CestoBasura;
    }

    /**
     * @ignore
     */
    public function setCestoBasura($CestoBasura)
    {
        $this->CestoBasura = $CestoBasura;
        return $this;
    }

    /**
     * @ignore
     */
    public function getPuertaEmergencia()
    {
        return $this->PuertaEmergencia;
    }

    /**
     * @ignore
     */
    public function setPuertaEmergencia($PuertaEmergencia)
    {
        $this->PuertaEmergencia = $PuertaEmergencia;
        return $this;
    }

    /**
     * @ignore
     */
    public function getAnchoSalida()
    {
        return $this->AnchoSalida;
    }
	
	/**
	 * @ignore
	 */
	public function getSuperficieDeposito() {
		return $this->SuperficieDeposito;
	}
	
	/**
	 * @ignore
	 */
	public function setSuperficieDeposito($SuperficieDeposito) {
		$this->SuperficieDeposito = $SuperficieDeposito;
		return $this;
	}
	
	/**
	 * @ignore
	 */
	public function setAnchoSalida($AnchoSalida) {
		$this->AnchoSalida = $AnchoSalida;
		return $this;
	}
	
	/**
	 * @ignore
	 */
	public function getEnParqueIndustrial() {
		return $this->EnParqueIndustrial;
	}
	
	/**
	 * @ignore
	 */
	public function setEnParqueIndustrial($EnParqueIndustrial) {
		$this->EnParqueIndustrial = $EnParqueIndustrial;
		return $this;
	}

    /**
     * @ignore
     */
    public function getComercios()
    {
        return $this->Comercios;
    }

    /**
     * @ignore
     */
    public function setComercios(Comercio $Comercios)
    {
        $this->Comercios = $Comercios;
        return $this;
    }

    /**
     * @ignore
     */
    public function getSubDomicilio()
    {
        return $this->SubDomicilio;
    }

    /**
     * @ignore
     */
    public function setSubDomicilio($SubDomicilio)
    {
        $this->SubDomicilio = $SubDomicilio;
        return $this;
    }
 

}
