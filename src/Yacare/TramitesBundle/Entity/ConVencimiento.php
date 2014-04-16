<?php

namespace Yacare\TramitesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait para cosas que tienen una fecha de vencimiento.
 */
trait ConVencimiento {
    /**
     * La fecha de vencimiento.
     * 
     * @var \DateTime
     * @ORM\Column(type="date", nullable=true)
     */
    private $Vencimiento;
    
    public function getVencimiento() {
        return $this->Vencimiento;
    }

    public function setVencimiento(\DateTime $Vencimiento = null) {
        $this->Vencimiento = $Vencimiento;
    }
}