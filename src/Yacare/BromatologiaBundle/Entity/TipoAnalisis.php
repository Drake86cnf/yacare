<?php

namespace Yacare\BromatologiaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\BromatologiaBundle\Entity\TipoAnalisis
 *
 * @ORM\Entity
 * @ORM\Table(name="Bromatologia_TipoAnalisis")
 */
class TipoAnalisis
{
    use \Yacare\BaseBundle\Entity\ConId;
    use \Yacare\BaseBundle\Entity\ConNombre;
    use \Yacare\BaseBundle\Entity\Versionable;
    use \Yacare\BaseBundle\Entity\Suprimible;
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
