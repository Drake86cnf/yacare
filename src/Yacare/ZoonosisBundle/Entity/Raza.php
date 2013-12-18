<?php

namespace Yacare\ZoonosisBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\ZoonosisBundle\Entity\Raza
 *
 * @ORM\Entity(repositoryClass="Yacare\BaseBundle\Entity\YacareBaseRepository")
 * @ORM\Table(name="Zoonosis_Raza")
 */
class Raza
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
    private $TipoAnimal;   
    
    public function getTipoNombreAnimal() {
        switch ($this->TipoAnimal){
            case 1:
                return 'Perro';
            case 2:
                return 'Gato';
            case 3:
                return 'Caballo';
            default:
                return '???';
        }
    }
    
    
     public function __toString() {
        return $this->getNombre();
    }
    
    
 
    public function getTipoAnimal() {
        return $this->TipoAnimal;
    }

    public function setTipoAnimal($TipoAnimal) {
        $this->TipoAnimal = $TipoAnimal;
    }


}
