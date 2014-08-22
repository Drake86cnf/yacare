<?php

namespace Yacare\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Agrega la capacidad de tener archivos adjuntos.
 */
trait ConAdjuntos
{
    /**
     * @ORM\ManyToMany(targetEntity="\Yacare\BaseBundle\Entity\Adjunto", cascade={ "persist" })
     */
    protected $Adjuntos;

    
    public function __construct()
    {
        $this->Adjuntos = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    public function getAdjuntos() {
        return $this->Adjuntos;
    }

    public function setAdjuntos($Adjuntos) {
        $this->Adjuntos = $Adjuntos;
    }
}
