<?php

namespace Yacare\BromatologiaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\BromatologiaBundle\Entity\DesinfeccionVehiculo
 *
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Table(name="Bromatologia_DesinfeccionVehiculo")
 */
class DesinfeccionVehiculo
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Tapir\BaseBundle\Entity\Versionable;
    use \Tapir\BaseBundle\Entity\Suprimible;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    
  /**
     * @ORM\ManyToOne(targetEntity="Yacare\BromatologiaBundle\Entity\Vehiculo")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $Vehiculo;  
     
    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $FechaDesinfeccionVehiculo;
   
    
     public function __toString() {
        return 'Certificado N* ' . $this->getId() . ' de ' . $this->getVehiculo()->getDominio();
    }
    
    
   
    public function getVehiculo() {
        return $this->Vehiculo;
    }
       
    public function setVehiculo($Vehiculo) {
        $this->Vehiculo = $Vehiculo;
    }

    public function getFechaDesinfeccionVehiculo() {
        return $this->FechaDesinfeccionVehiculo;
    }

    public function setFechaDesinfeccionVehiculo(\DateTime $FechaDesinfeccionVehiculo) {
        $this->FechaDesinfeccionVehiculo = $FechaDesinfeccionVehiculo;
    }

    }
