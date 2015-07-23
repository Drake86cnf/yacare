<?php
namespace Tapir\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Agrega una columna de URL a una entidad y sus métodos (getter y setter).
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
trait ConUrl
{

    /**
     * La URL asociada a la entidad.
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Url;

    /**
     *
     * @ignore
     *
     */
    public function getUrl()
    {
        return $this->Url;
    }

    /**
     *
     * @ignore
     *
     */
    public function setUrl($Url)
    {
        $this->Url = $Url;
    }
}
