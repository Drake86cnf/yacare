<?php

namespace Tapir\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Importable
 */
trait Importable
{
    /**
     * @var string $ImportSrc
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ImportSrc;
    
    /**
     * @var string $ImportId
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $ImportId;
    
    /**
    * @var DateTime $ImportedAt
    * @ORM\Column(type="datetime", nullable=true)
    */
    private $ImportedAt;

    public function getImportSrc()
    {
        return $this->ImportSrc;
    }
    
    public function setImportSrc($importSrc)
    {
        $this->ImportSrc = $importSrc;
    }
    
    public function getImportId()
    {
        return $this->ImportId;
    }
    
    public function setImportId($importId)
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
