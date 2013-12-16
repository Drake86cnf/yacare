<?php

namespace Yacare\TramitesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

trait ConSeguimiento {
    
    /**
     * @ORM\ManyToOne(targetEntity="\Yacare\OrganizacionBundle\Entity\Departamento")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $EnPoderDe;
    
    
    public function getExpedienteNumero() {
        return $this->ExpedienteNumero;
    }

    public function setExpedienteNumero($ExpedienteNumero) {
        $this->ExpedienteNumero = $ExpedienteNumero;
    }
}