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
     * @var integer $Eliminado
     *
     * @ORM\Column(name="Eliminado", type="integer")
     * @ORM\Version
     */
    private $Eliminado;
    
    public function getEliminado() {
        return $this->Eliminado;
    }

    public function setEliminado($Eliminado) {
        $this->Eliminado = $Eliminado;
    }
}
