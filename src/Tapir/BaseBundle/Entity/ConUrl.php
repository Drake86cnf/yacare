<?php
namespace Tapir\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Agrega una columna de URL a una entidad y sus métodos (getter y setter).
 *
 * @author Ernesto Carrea <equistango@gmail.com>
 */
trait ConUrl
{

    /**
     *
     * @var string $Url
     *      @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Url;

    public function getUrl()
    {
        return $this->Url;
    }

    public function setUrl($Url)
    {
        $this->Url = $Url;
    }
}
