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
    private $FechaDesinfeccion;
    
    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $ComprobanteNumero;
   
    public function getVehiculo() {
        return $this->Vehiculo;
    }

    public function setVehiculo($Vehiculo) {
        $this->Vehiculo = $Vehiculo;
    }

    public function getFechaDesinfeccion() {
        return $this->FechaDesinfeccion;
    }

    public function setFechaDesinfeccion(\DateTime $FechaDesinfeccion) {
        $this->FechaDesinfeccion = $FechaDesinfeccion;
    }

    public function getComprobanteNumero() {
        return $this->ComprobanteNumero;
    }

    public function setComprobanteNumero($ComprobanteNumero) {
        $this->ComprobanteNumero = $ComprobanteNumero;
    }


    }
