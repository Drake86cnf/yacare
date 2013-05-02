<?php

namespace Yacare\RecursosHumanosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\RecursosHumanosBundle\Entity\Agente
 *
 * @ORM\Table(name="Rrhh_Agente")
 * @ORM\Entity
 */
class Agente
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="\Yacare\BaseBundle\Entity\Persona", inversedBy="Agente")
     * @ORM\JoinColumn(name="Persona", referencedColumnName="id")
     */
    protected $Persona;

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

    public function getId()
    {
        return $this->id;
    }


    public function getPersona() {
        return $this->Persona;
    }

    public function setPersona($Persona) {
        $this->Persona = $Persona;
    }

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
