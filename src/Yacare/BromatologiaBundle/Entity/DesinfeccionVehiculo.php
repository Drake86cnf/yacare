<?php

namespace Yacare\BromatologiaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\BromatologiaBundle\Entity\DesinfeccionVehiculo
 *
 * @ORM\Entity
 * @ORM\Table(name="Bromatologia_DesinfeccionVehiculo")
 */
class DesinfeccionVehiculo
{
    use \Yacare\BaseBundle\Entity\ConId;
    use \Yacare\BaseBundle\Entity\Versionable;
    use \Yacare\BaseBundle\Entity\Suprimible;
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
    
    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $ComprobanteNumero;
    
    
       public function __toString() {
        return $this->getVehiculo()->getDominio();
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

    public function getComprobanteNumero() {
        return $this->ComprobanteNumero;
    }

    public function setComprobanteNumero($ComprobanteNumero) {
        $this->ComprobanteNumero = $ComprobanteNumero;
    }


    }
