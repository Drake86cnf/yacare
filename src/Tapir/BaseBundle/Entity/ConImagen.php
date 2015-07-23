<?php
namespace Tapir\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Agrega una propiedad de imagen a una entidad.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
trait ConImagen
{

    /**
     * La imagen, en formato binario.
     *
     * @var $imagen @ORM\Column(name="imagen", type="blob", nullable=true)
     */
    private $imagen;

    /**
     * Obtiene un valor que indica si el elemento actual tiene una imagen.
     * 
     * @return bool True si el campo imagen tiene asignado un valor.
     */
    public function TieneImagen()
    {
        if ($this->imagen) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Obtiene la imagen en formato base64.
     * 
     * @return string
     */
    public function getImagenBase64()
    {
        return base64_encode($this->imagen);
    }

    /**
     *
     * @ignore
     *
     */
    public function getImagen()
    {
        return $this->imagen;
    }

    /**
     *
     * @ignore
     *
     */
    public function setImagen($imagen)
    {
        $this->imagen = $imagen;
    }
}
