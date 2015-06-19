<?php
namespace Tapir\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Agrega una columna de notas a una entidad y sus métodos (getter y setter).
 *
 * Las notas son similares a las observaciones.
 *
 * @see ConObs
 * @author Ernesto Carrea <equistango@gmail.com>
 */
trait ConNotas
{

    /**
     * El texto de las notas.
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $Notas;

    /**
     *
     * @ignore
     *
     */
    public function getNotas()
    {
        return $this->Notas;
    }

    /**
     *
     * @ignore
     *
     */
    public function setNotas($Notas)
    {
        $this->Notas = trim($Notas);
    }
}
