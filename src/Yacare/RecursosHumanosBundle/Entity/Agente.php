<?php

namespace Yacare\RecursosHumanosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\RecursosHumanosBundle\Entity\Agente
 *
 * @ORM\Table(name="Rrhh_Agente")
 * @ORM\Entity
 */
class Agente extends \Yacare\BaseBundle\Entity\Persona
{
    /**
     * @var integer $Legajo
     * @ORM\Column(name="Legajo", type="integer")
     */
    private $Legajo;

    /**
     * @var \DateTime $FechaIngreso
     * @ORM\Column(name="FechaIngreso", type="date")
     */
    private $FechaIngreso;

    public function getLegajo() {
        return $this->Legajo;
    }

    public function setLegajo($Legajo) {
        $this->Legajo = $Legajo;
    }

    public function getFechaIngreso() {
        return $this->FechaIngreso;
    }

    public function setFechaIngreso(\DateTime $FechaIngreso) {
        $this->FechaIngreso = $FechaIngreso;
    }
}
