<?php
namespace Yacare\BaseBundle\Model;

/**
 * Agrega la capacidad de ser ordenable.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
trait Ordenable
{    
    /**
     * El orden.
     * 
     * @var integer
     * 
     * @ORM\Column(type="integer")
     */
    protected $Orden = 1;

    /**
     * @ignore
     */
    public function getOrden()
    {
        return $this->Orden;
    }

    /**
     * @ignore
     */
    public function setOrden($Orden)
    {
        $this->Orden = $Orden;
    }
}
