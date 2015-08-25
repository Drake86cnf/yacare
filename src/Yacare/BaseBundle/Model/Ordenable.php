<?php
namespace Yacare\BaseBundle\Model;

trait Ordenable
{    
    /**
     * @ORM\Column(type="integer")
     */
    protected $Orden = 1;

    public function getOrden()
    {
        return $this->Orden;
    }

    public function setOrden($Orden)
    {
        $this->Orden = $Orden;
    }
}