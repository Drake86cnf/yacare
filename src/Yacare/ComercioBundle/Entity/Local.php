<?php
namespace Yacare\ComercioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\ComercioBundle\Entity\Local
 *
 * @ORM\Entity
 * @ORM\Table(name="Comercio_Local")
 */
class Local {
    use \Yacare\BaseBundle\Entity\ConId;
    use \Yacare\BaseBundle\Entity\ConDomicilio;
    use \Yacare\BaseBundle\Entity\Versionable;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    
    /**
     * @ORM\ManyToOne(targetEntity="Yacare\BaseBundle\Entity\Persona")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $Propietario;
    
      /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $TipoLugar;
        
    public function __toString() {
        return $this->getDomicilio();
    }
    
    public function getPropietario() {
        return $this->Propietario;
    }

    public function setPropietario($Propietario) {
        $this->Propietario = $Propietario;
    }
    
    public function getTipoLugar() {
        return $this->TipoLugar;
    }

    public function setTipoLugar($TipoLugar) {
        $this->TipoLugar = $TipoLugar;
    }

}

?>
