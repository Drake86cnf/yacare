<?php

namespace Tapir\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ConNombre
 *
 */
trait ConNombre
{
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nombre;
    
    public function __toString() {
        return $this->getNombre();
    }
    
    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

}
