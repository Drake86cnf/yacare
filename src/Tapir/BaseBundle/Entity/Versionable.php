<?php
namespace Tapir\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait que agrega la capacidad de versionar una entidad.
 *
 * Agrega un campo "Version" y que se inicia en 1 durante la creación de la
 * entidad y se incrementa en uno en cada actualización.
 *
 * @author Ernesto Carrea <equistango@gmail.com>
 */
trait Versionable
{

    /**
     *
     * @var integer $Version
     *     
     *      @ORM\Column(name="Version", type="integer")
     *      @ORM\Version
     */
    private $Version;

    public function getVersion()
    {
        return $this->Version;
    }

    public function setVersion($Version)
    {
        $this->Version = $Version;
    }
}
