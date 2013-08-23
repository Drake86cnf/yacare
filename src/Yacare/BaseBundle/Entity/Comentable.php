<?php

namespace Yacare\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Comentable
 */
trait Comentable
{
    /**
     * @ORM\OneToMany(targetEntity="\Yacare\BaseBundle\Entity\Comentario")
     */
    private $ListaComentarios;
    
    public function __construct()
    {
        $this->ListaComentarios = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getListaComentarios() {
        return $this->ListaComentarios;
    }

    public function setListaComentarios($ListaComentarios) {
        $this->ListaComentarios = $ListaComentarios;
    }
}
