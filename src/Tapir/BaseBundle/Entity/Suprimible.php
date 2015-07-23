<?php
namespace Tapir\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Agrega la capacidad de suprimir (soft-delete) una entidad.
 *
 * La supresión no es permanente, se hace levantando una bandera en la columna
 * "suprimido".
 *
 * @see Eliminable
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
trait Suprimible
{

    /**
     * Indica si la entidad fue suprimido (soft-delete).
     *
     * @ORM\Column(type="boolean")
     */
    private $Suprimido = 0;

    /**
     * Marca la entidad como suprimida.
     */
    public function Suprimir()
    {
        $this->setSuprimido(1);
    }

    /**
     *
     * @ignore
     *
     */
    public function getSuprimido()
    {
        return $this->Suprimido;
    }

    /**
     *
     * @ignore
     *
     */
    public function setSuprimido($Suprimido)
    {
        $this->Suprimido = $Suprimido;
    }
}
