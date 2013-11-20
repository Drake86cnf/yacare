<?php

namespace Yacare\TramitesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

trait ConVencimiento {
    /**
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