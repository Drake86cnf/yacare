<?php
namespace Tapir\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait que agrega la capacidad de suprimir (soft-delete) una entidad.
 *
 * La supresión no es permanente, se hace levantando una bandera en la columna
 * "suprimido".
 *
 * @see Eliminable
 *
 * @author Ernesto Carrea <equistango@gmail.com>
 */
trait Suprimible
{

    /**
     * @ORM\Column(type="boolean")
     */
    private $Suprimido = 0;

    public function Suprimir()
    {
        $this->setSuprimido(1);
    }

    public function getSuprimido()
    {
        return $this->Suprimido;
    }

    public function setSuprimido($Suprimido)
    {
        $this->Suprimido = $Suprimido;
    }
}
