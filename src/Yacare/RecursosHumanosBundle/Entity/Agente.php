<?php

namespace Yacare\RecursosHumanosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\RecursosHumanosBundle\Entity\Agente
 *
 * @ORM\Table(name="Rrhh_PersonaAgente")
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
     *
     * @ORM\Column(name="Legajo", type="integer")
     */
    private $Legajo;

    /**
     * @var \DateTime $FechaIngreso
     *
     * @ORM\Column(name="FechaIngreso", type="date")
     */
    private $FechaIngreso;

    /**
     * @var integer $Categoria
     *
     * @ORM\Column(name="Categoria", type="integer")
     */
    private $Categoria;

    /**
     * @var integer $Cargo
     *
     * @ORM\Column(name="Cargo", type="integer")
     */
    private $Cargo;

    /**
     * @var integer $Area
     *
     * @ORM\Column(name="Area", type="integer")
     */
    private $Area;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set Legajo
     *
     * @param integer $legajo
     * @return PersonaAgente
     */
    public function setLegajo($legajo)
    {
        $this->Legajo = $legajo;
    
        return $this;
    }

    /**
     * Get Legajo
     *
     * @return integer 
     */
    public function getLegajo()
    {
        return $this->Legajo;
    }

    /**
     * Set FechaIngreso
     *
     * @param \DateTime $fechaIngreso
     * @return PersonaAgente
     */
    public function setFechaIngreso($fechaIngreso)
    {
        $this->FechaIngreso = $fechaIngreso;
    
        return $this;
    }

    /**
     * Get FechaIngreso
     *
     * @return \DateTime 
     */
    public function getFechaIngreso()
    {
        return $this->FechaIngreso;
    }

    /**
     * Set Categoria
     *
     * @param integer $categoria
     * @return PersonaAgente
     */
    public function setCategoria($categoria)
    {
        $this->Categoria = $categoria;
    
        return $this;
    }

    /**
     * Get Categoria
     *
     * @return integer 
     */
    public function getCategoria()
    {
        return $this->Categoria;
    }

    /**
     * Set Cargo
     *
     * @param integer $cargo
     * @return PersonaAgente
     */
    public function setCargo($cargo)
    {
        $this->Cargo = $cargo;
    
        return $this;
    }

    /**
     * Get Cargo
     *
     * @return integer 
     */
    public function getCargo()
    {
        return $this->Cargo;
    }

    /**
     * Set Area
     *
     * @param integer $area
     * @return PersonaAgente
     */
    public function setArea($area)
    {
        $this->Area = $area;
    
        return $this;
    }

    /**
     * Get Area
     *
     * @return integer 
     */
    public function getArea()
    {
        return $this->Area;
    }
}
