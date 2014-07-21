<?php

namespace Tapir\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Agrega una columna de notas a una entidad y sus métodos (getter y setter).
 *
 * @author Ernesto Carrea <equistango@gmail.com>
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
