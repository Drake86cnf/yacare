<?php

namespace Yacare\TramitesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

trait ConApoderado {
    /**
     * @ORM\ManyToOne(targetEntity="Yacare\BaseBundle\Entity\Persona")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $Apoderado;
    
    public function getApoderado() {
        return $this->Apoderado;
    }

    public function setApoderado($Apoderado) {
        $this->Apoderado = $Apoderado;
    }
}