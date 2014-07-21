<?php

namespace Tapir\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Agrega una columna de observaciones a una entidad y sus métodos (getter y setter).
 *
 * @author Ernesto Carrea <equistango@gmail.com>
 */
trait ConObs
{
    /**
     * @var string $obs
     * @ORM\Column(type="text", nullable=true)
     */
    private $obs;
    
    public function getObs() {
        return $this->obs;
    }

    public function setObs($obs) {
        $this->obs = $obs;
    }

}
