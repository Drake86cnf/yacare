<?php

namespace Yacare\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Eliminable
 *
 */
trait Eliminable
{
    /**
     * @var integer
     * @ORM\Column(type="integer", default=0)
     */
    private $Eliminado;
    
    public function getEliminado() {
        return $this->Eliminado;
    }

    public function setEliminado($Eliminado) {
        $this->Eliminado = $Eliminado;
    }
    
    public function Eliminar() {
        $this->setEliminado(1);
    }
}
