<?php

namespace Tapir\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Archivable
 */
trait Archivable
{
    /**
     * @ORM\Column(type="boolean")
     */
    private $Archivado = 0;
    
    public function Archivar() {
        $this->setArchivado(1);
    }
    
    public function getArchivado() {
        return $this->Archivado;
    }

    public function setArchivado($Archivado) {
        $this->Archivado = $Archivado;
    }
}