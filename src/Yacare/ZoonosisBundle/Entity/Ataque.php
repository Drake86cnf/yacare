<?php

namespace Yacare\ZoonosisBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\ZoonosisBundle\Entity\Ataque
 *
 * @ORM\Entity
 * @ORM\Table(name="Zoonosis_Ataque")
 */
class Ataque
{
    use \Yacare\BaseBundle\Entity\ConId;
    use \Yacare\BaseBundle\Entity\Versionable;
    use \Yacare\BaseBundle\Entity\Suprimible;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    
    /**
     * @ORM\ManyToOne(targetEntity="Yacare\ZoonosisBundle\Entity\Microchip")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $Mascota;
    
       /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $Aquien;
    
    
     public function getAquienNombre() {
        switch ($this->Aquien){
            case 1:
                return 'Persona';
            case 2:
                return 'Mascota';
            default:
                return '???';
        }
    }
    
     /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $FechaAtaque;
    
           
      public function __toString() {
        return $this->getMascota()->getMicrochip();
    }
    
    
      
    public function getMascota() {
        return $this->Mascota;
    }

    public function setMascota($Mascota) {
        $this->Mascota = $Mascota;
    }

    public function getAquien() {
        return $this->Aquien;
    }

    public function setAquien($Aquien) {
        $this->Aquien = $Aquien;
    }
 
    public function getFechaAtaque() {
        return $this->FechaAtaque;
    }

    public function setFechaAtaque(\DateTime $FechaAtaque) {
        $this->FechaAtaque = $FechaAtaque;
    }

}
