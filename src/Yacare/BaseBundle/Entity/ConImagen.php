<?php

namespace Yacare\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ConImagen
 *
 */
trait ConImagen
{
    /**
     * @var blob $Imagen
     * @ORM\Column(name="Imagen", type="blob")
     */
    private $Imagen;

    public function getImagen() {
        return $this->Imagen;
    }

    public function setImagen(blob $Imagen) {
        $this->Imagen = $Imagen;
    }
}
