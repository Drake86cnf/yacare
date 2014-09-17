<?php
namespace Tapir\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Agrega la los campos (y métodos) para hacer seguimiento de registros importados 
 * desde otra fuente de datos.
 *
 * @author Ernesto Carrea <equistango@gmail.com>
 */
trait Importable
{

    /**
     * La fuente desde la cual fue importado el registro.
     *
     * Es de texto libre, puede ser el nombre de una tabla, base.tabla, archivo,
     * o cualquier cosa que en conjunto con el ImportId permitan identificar el origen
     * de este registro.
     *
     * @see $ImportId
     *
     * @var string $ImportSrc
     *      @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ImportSrc;

    /**
     * El id o valor de clave primaria original de este registro en su origen.
     *
     * @see $ImportSrc
     *
     * @var string $ImportId
     *      @ORM\Column(type="string", length=50, nullable=true)
     */
    private $ImportId;

    /**
     * La fecha y hora de la última importación.
     *
     * @var DateTime $ImportedAt
     *      @ORM\Column(type="datetime", nullable=true)
     */
    private $ImportedAt;

    /**
     * @ignore
     */
    public function getImportSrc()
    {
        return $this->ImportSrc;
    }

    /**
     * @ignore
     */
    public function setImportSrc($importSrc)
    {
        $this->ImportSrc = $importSrc;
    }

    /**
     * @ignore
     */
    public function getImportId()
    {
        return $this->ImportId;
    }

    /**
     * @ignore
     */
    public function setImportId($importId)
    {
        $this->ImportId = $importId;
    }

    /**
     * @ignore
     */
    public function getImportedAt()
    {
        return $this->ImportedAt;
    }

    /**
     * @ignore
     */
    public function setImportedAt(\DateTime $importedAt)
    {
        $this->ImportedAt = $importedAt;
    }
}
