<?php

namespace Yacare\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Suprimible
 */
trait Suprimible
{
    /**
     * @var integer
     * @ORM\Column(type="integer")
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
