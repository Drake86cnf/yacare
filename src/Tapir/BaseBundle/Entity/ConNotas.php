<?php
namespace Tapir\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Agrega una columna de notas a una entidad y sus métodos (getter y setter).
 *
 * Las notas son similares a las observaciones.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 * 
 * @see \Tapir\BaseBundle\Entity\ConObs ConObs
 */
trait ConNotas
{
    /**
     * El texto de las notas.
     * 
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $Notas;

    /**
     * @ignore
     */
    public function getNotas()
    {
        return $this->Notas;
    }

    /**
     * @ignore
     */
    public function setNotas($Notas)
    {
        $this->Notas = trim($Notas);
    }
}
