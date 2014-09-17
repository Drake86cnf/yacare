<?php
namespace Tapir\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Agrega una propiedad de imagen a una entidad.
 *
 * @author Ernesto Carrea <equistango@gmail.com>
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
     * Obtiene la imagen en formato base64.
     * @return string
     */
    public function getImagenBase64()
    {
        return base64_encode($this->imagen);
    }

    /**
     * @ignore
     */
    public function getImagen()
    {
        return $this->imagen;
    }

    /**
     * @ignore
     */
    public function setImagen($imagen)
    {
        $this->imagen = $imagen;
    }
}
