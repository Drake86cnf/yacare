<?php

namespace Yacare\ExpedientesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

trait ConExpediente {
    
    /**
     * @ORM\ManyToOne(targetEntity="Yacare\ExpedientesBundle\Entity\Expediente")
     */
    protected $Expediente;

    
    public function getExpediente() {
        return $this->Expediente;
    }

    public function setExpediente($Expediente) {
        $this->Expediente = $Expediente;
    }
}