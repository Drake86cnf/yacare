<?php
namespace Tapir\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Agrega la capacidad de versionar una entidad.
 *
 * Agrega un campo "Version" y que se inicia en 1 durante la creación de la
 * entidad y se incrementa en uno en cada actualización.
 *
 * @author Ernesto Carrea <equistango@gmail.com>
 */
trait Versionable
{

    /**
     * La versión del registro.
     *
     * La versión comienza en 1 en la creación del registro y se incrementa
     * en cada modificación.
     *
     * @var integer $Version
     *     
     *      @ORM\Column(name="Version", type="integer")
     *      @ORM\Version
     */
    private $Version;

    /**
     *
     * @ignore
     *
     */
    public function getVersion()
    {
        return $this->Version;
    }

    /**
     *
     * @ignore
     *
     */
    public function setVersion($Version)
    {
        $this->Version = $Version;
    }
}
