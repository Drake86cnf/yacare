<?php

namespace Yacare\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ConNombre
 *
 */
trait ConNombre
{
        /**
     * @var string $Nombre
     * @ORM\Column(type="string", length=255)
     */
    private $Nombre;
    
        public function setNombre($nombre)
    {
        $this->Nombre = $nombre;
    }

    public function getNombre()
    {
        return $this->Nombre;
    }
    
    public function __toString() {
        return $this->getNombre();
    }
}
