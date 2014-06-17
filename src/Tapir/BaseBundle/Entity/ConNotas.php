<?php

namespace Tapir\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ConNotas
 */
trait ConNotas
{
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $Notas;

    public function getNotas() {
        return $this->Notas;
    }

    public function setNotas($Notas) {
        $this->Notas = $Notas;
    }
}
