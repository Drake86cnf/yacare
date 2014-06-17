<?php

namespace Tapir\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ConImagen
 *
 */
trait ConImagen
{
    /**
     * @var $imagen
     * @ORM\Column(type="blob", nullable=true)
     */
    private $imagen;
    
    public function getImagenBase64() {
        return base64_encode($this->imagen);
    }
    
    public function getImagen() {
        return $this->imagen;
    }

    public function setImagen($imagen) {
        $this->imagen = $imagen;
    }
}
