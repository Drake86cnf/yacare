<?php
namespace Tapir\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Agrega una columna de observaciones y sus métodos (getter y setter) a una entidad.
 *
 * @see ConNotas
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
trait ConObs
{

    /**
     * El texto de las observaciones.
     * 
     * @var string $obs
     *      @ORM\Column(type="text", nullable=true)
     */
    private $Obs;

    /**
     *
     * @ignore
     *
     */
    public function getObs()
    {
        return $this->Obs;
    }

    /**
     *
     * @ignore
     *
     */
    public function setObs($Obs)
    {
        $this->Obs = $Obs;
    }
}
