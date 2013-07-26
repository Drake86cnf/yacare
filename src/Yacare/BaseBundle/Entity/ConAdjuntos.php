<?php

namespace Yacare\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ConAdjuntos
 *
 */
trait ConAdjuntos
{
    /**
     * @ORM\ManyToMany(targetEntity="Adjunto")
     */
    private $Adjuntos;
    
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
