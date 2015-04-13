<?php
namespace Tapir\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Agrega la capacidad de archivar una entidad.
 *
 * @author Ernesto Carrea <equistango@gmail.com>
 */
trait Archivable
{

    /**
     * Indica si la entidad fue archivada.
     *
     * @ORM\Column(type="boolean")
     */
    private $Archivado = 0;

    /**
     * Marca la entidad como archivada.
     */
    public function Archivar()
    {
        $this->setArchivado(1);
    }

    /**
     *
     * @ignore
     *
     */
    public function getArchivado()
    {
        return $this->Archivado;
    }

    /**
     *
     * @ignore
     *
     */
    public function setArchivado($Archivado)
    {
        $this->Archivado = $Archivado;
    }
}