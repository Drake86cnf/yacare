<?php
namespace Yacare\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Agrega a una entidad la capacidad de adjuntar comentarios.
 *
 * @author Ernesto Carrea <equistango@gmail.com>
 */
trait Comentable
{

    /**
     * Los comentarios asociados a esta entidad.
     *
     * @ORM\ManyToMany(targetEntity="\Yacare\BaseBundle\Entity\Comentario", cascade={ "persist" })
     */
    protected $Comentarios;

    public function __construct()
    {
        $this->Comentarios = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     *
     * @ignore
     *
     */
    public function getComentarios()
    {
        return $this->Comentarios;
    }

    /**
     *
     * @ignore
     *
     */
    public function setComentarios($Comentarios)
    {
        $this->Comentarios = $Comentarios;
    }
}
