<?php

namespace Yacare\BromatologiaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\BromatologiaBundle\Entity\TipoAnalisis
 *
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Table(name="Bromatologia_TipoAnalisis")
 */
class TipoAnalisis
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Tapir\BaseBundle\Entity\ConNombre;
    use \Tapir\BaseBundle\Entity\Versionable;
    use \Tapir\BaseBundle\Entity\Suprimible;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    
 /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $Costo;
    
 /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $Tipo;   
    
    public function getTipoNombre() {
        switch ($this->Tipo){
            case 1:
                return 'Físico Químico';
            case 2:
                return 'Microbiológico';
            default:
                return '???';
        }
    }
    
    
    
 
    public function getCosto() {
        return $this->Costo;
    }

    public function setCosto($Costo) {
        $this->Costo = $Costo;
    }

    public function getTipo() {
        return $this->Tipo;
    }

    public function setTipo($Tipo) {
        $this->Tipo = $Tipo;
    }


}
