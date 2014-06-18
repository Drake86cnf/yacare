<?php

namespace Tapir\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Suprimible
 */
trait Suprimible
{
    /**
     * @ORM\Column(type="boolean")
     */
    private $Suprimido = 0;
    
    public function Suprimir() {
        $this->setSuprimido(1);
    }
    
    public function getSuprimido() {
        return $this->Suprimido;
    }

    public function setSuprimido($Suprimido) {
        $this->Suprimido = $Suprimido;
    }
}
