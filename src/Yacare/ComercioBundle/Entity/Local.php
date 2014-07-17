<?php
namespace Yacare\ComercioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\ComercioBundle\Entity\Local
 *
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Table(name="Comercio_Local")
 */
class Local {
    use \Tapir\BaseBundle\Entity\ConId;
    use \Tapir\BaseBundle\Entity\ConNombre;
    //use \Yacare\BaseBundle\Entity\ConDomicilioLocal;
    use \Tapir\BaseBundle\Entity\Suprimible;
    use \Tapir\BaseBundle\Entity\Versionable;
    use \Yacare\CatastroBundle\Entity\ConPartida;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    
    /**
     * @ORM\ManyToOne(targetEntity="Yacare\BaseBundle\Entity\Persona")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=true)
     */
    protected $Propietario;
    
    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $Tipo;
    
    /**
     * @var float
     * @ORM\Column(type="float")
     */
    private $Superficie;
    
    /**
     * @ORM\ManyToOne(targetEntity="Yacare\ComercioBundle\Entity\DepositoClase")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=true)
     */
    protected $DepositoClase;
    
    
    public function setPartida($Partida) {
        $this->Partida = $Partida;
        $this->setPropietario($Partida->getTitular());
    }
    
    public function __toString() {
        return $this->ConstruirNombre();
    }
    
    private function ConstruirNombre() {
        $res = $this->getTipo();
        if($this->getTipo() == 'Depósito' && $this->getDepositoClase()) {
            $res .= ' clase ' . $this->getDepositoClase()->getTipo();
        }
        
        if($this->getPartida()) {
            $res .= ' en ' .  $this->getPartida()->getDomicilio();
        }
        
        $this->setNombre($res);
        
        return $res;
    }
    
    public function getPropietario() {
        return $this->Propietario;
    }

    public function setPropietario($Propietario) {
        $this->Propietario = $Propietario;
        $this->ConstruirNombre();
    }
    
    public function getTipo() {
        return $this->Tipo;
    }

    public function setTipo($Tipo) {
        $this->Tipo = $Tipo;
        $this->ConstruirNombre();
    }
    
    public function getSuperficie() {
        return $this->Superficie;
    }

    public function setSuperficie($Superficie) {
        $this->Superficie = $Superficie;
    }
    
    public function getDepositoClase() {
        return $this->DepositoClase;
    }

    public function setDepositoClase($DepositoClase) {
        $this->DepositoClase = $DepositoClase;
    }
}
