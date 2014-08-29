<?php
namespace Tapir\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Agrega una columna de nombre a una entidad y sus métodos (getter y setter).
 *
 * @author Ernesto Carrea <equistango@gmail.com>
 */
trait ConNombre
{

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nombre;

    public function __toString()
    {
        return $this->getNombre();
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }
}
