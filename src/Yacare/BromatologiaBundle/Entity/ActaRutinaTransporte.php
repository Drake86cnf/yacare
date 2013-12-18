<?php

namespace Yacare\BromatologiaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\BromatologiaBundle\Entity\ActaRutinaTransporte
 *
 * @ORM\Entity(repositoryClass="Yacare\BaseBundle\Entity\YacareBaseRepository")
 * @ORM\Table(name="Bromatologia_ActaRutinaTransporte")
 */
class ActaRutinaTransporte extends \Yacare\BromatologiaBundle\Entity\ActaRutina
{    
    
    /**
     * @ORM\ManyToOne(targetEntity="Yacare\BromatologiaBundle\Entity\Vehiculo")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $Vehiculo; 
    
 
    public function getVehiculo() {
        return $this->Vehiculo;
    }

    public function setVehiculo($Vehiculo) {
        $this->Vehiculo = $Vehiculo;
    }
}
