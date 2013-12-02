<?php

namespace Yacare\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Comentable
 */
trait Comentable
{
    /**
     * @ORM\ManyToMany(targetEntity="\Yacare\BaseBundle\Entity\Comentario", cascade={ "persist" })
     */
    protected $Comentarios;
    
    
    public function __construct()
    {
        $this->Comentarios = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getComentarios() {
        return $this->Comentarios;
    }

    public function setComentarios($Comentarios) {
        $this->Comentarios = $Comentarios;
    }
}
