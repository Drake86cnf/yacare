<?php

namespace Yacare\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Versionable
 *
 */
trait Importable
{
    /**
     * @var string $ImportId
     *
     * @ORM\Column(type="string", length=255)
     */
    private $ImportId;
    
    /**
    * @var DateTime $ImportedAt
    *
    * @ORM\Column(type="datetime", nullable=true)
    */
    private $ImportedAt;

    
    public function getImportId()
    {
        return $this->ImportId;
    }
    
    public function setImportId(\DateTime $importId)
    {
        $this->ImportId = $importId;
    }

    public function getImportedAt()
    {
        return $this->ImportedAt;
    }
    
    public function setImportedAt(\DateTime $importedAt)
    {
        $this->ImportedAt = $importedAt;
    }

}
