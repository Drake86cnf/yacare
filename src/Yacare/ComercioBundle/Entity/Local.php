<?php
namespace Yacare\ComercioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
    // use \Yacare\BaseBundle\Entity\ConDomicilioLocal;
    use \Tapir\BaseBundle\Entity\Suprimible;
    use \Tapir\BaseBundle\Entity\Versionable;
    use \Yacare\CatastroBundle\Entity\ConPartida;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;

    /**
     * El tipo de local (local, oficina, depósito, etc.).
     *
     * @var string @ORM\Column(type="string", length=255)
     */
    private $Tipo;

    /**
     * La superficie en metros cuadrados.
     *
     * @var float @ORM\Column(type="float")
     */
    private $Superficie;

    /**
     * La clase de depósito.
     * 
     * Sólo aplica si Tipo es "Depósito".
     * 
     * @see $Tipo
     * 
     * @ORM\ManyToOne(targetEntity="Yacare\ComercioBundle\Entity\DepositoClase")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=true)
     */
    protected $DepositoClase;

    /**
     * Indica si el local comercial posee vereda municipal reglamentaria.
     * 
     * @ORM\Column(type="integer",nullable=true)
     */
    private $VeredaMunicipal;

    /**
     * Indica si el local comercial tiene canaletas reglamentarias.
     * 
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $Canaletas;

    /**
     * Indica si el local comercial posee cesto de basura.
     * 
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $CestoBasura;

    /**
     * Indica si el local comercial tiene salidas de emergencia.
     * 
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $PuertaEmergencia;

    /**
     * Indica la cantidad de anchos de salidas que tiene un local comercial.
     * 
     * @ORM\Column(type="integer", nullable=true)
     */
    private $AnchoSalida;

    public function setPartida($Partida)
    {
        $this->Partida = $Partida;
        $this->setPropietario($Partida->getTitular());
    }

    public function __toString()
    {
        return $this->ConstruirNombre();
    }

    private function ConstruirNombre()
    {
        $res = $this->getTipo();
        if ($this->getTipo() == 'Depósito' && $this->getDepositoClase()) {
            $res .= ' clase ' . $this->getDepositoClase()->getTipo();
        }
        
        if ($this->getPartida()) {
            $res .= ' en ' . $this->getPartida()->getDomicilio();
        }
        
        $this->setNombre($res);
        
        return $res;
    }
    
    public function setTipo($Tipo)
    {
        $this->Tipo = $Tipo;
        $this->ConstruirNombre();
    }
    

    // *** Getters y setters

    /**
     *
     * @ignore
     *
     */
    public function getTipo()
    {
        return $this->Tipo;
    }

    /**
     *
     * @ignore
     *
     */
    public function getSuperficie()
    {
        return $this->Superficie;
    }

    /**
     *
     * @ignore
     *
     */
    public function setSuperficie(float $Superficie)
    {
        $this->Superficie = $Superficie;
        return $this;
    }

    /**
     *
     * @ignore
     *
     */
    public function getDepositoClase()
    {
        return $this->DepositoClase;
    }

    /**
     *
     * @ignore
     *
     */
    public function setDepositoClase($DepositoClase)
    {
        $this->DepositoClase = $DepositoClase;
        return $this;
    }

    /**
     *
     * @ignore
     *
     */
    public function getVeredaMunicipal()
    {
        return $this->VeredaMunicipal;
    }

    /**
     *
     * @ignore
     *
     */
    public function setVeredaMunicipal($VeredaMunicipal)
    {
        $this->VeredaMunicipal = $VeredaMunicipal;
        return $this;
    }

    /**
     *
     * @ignore
     *
     */
    public function getCanaletas()
    {
        return $this->Canaletas;
    }

    /**
     *
     * @ignore
     *
     */
    public function setCanaletas($Canaletas)
    {
        $this->Canaletas = $Canaletas;
        return $this;
    }

    /**
     *
     * @ignore
     *
     */
    public function getCestoBasura()
    {
        return $this->CestoBasura;
    }

    /**
     *
     * @ignore
     *
     */
    public function setCestoBasura($CestoBasura)
    {
        $this->CestoBasura = $CestoBasura;
        return $this;
    }

    /**
     *
     * @ignore
     *
     */
    public function getPuertaEmergencia()
    {
        return $this->PuertaEmergencia;
    }

    /**
     *
     * @ignore
     *
     */
    public function setPuertaEmergencia($PuertaEmergencia)
    {
        $this->PuertaEmergencia = $PuertaEmergencia;
        return $this;
    }

    /**
     *
     * @ignore
     *
     */
    public function getAnchoSalida()
    {
        return $this->AnchoSalida;
    }

    /**
     *
     * @ignore
     *
     */
    public function setAnchoSalida($AnchoSalida)
    {
        $this->AnchoSalida = $AnchoSalida;
        return $this;
    }
}