<?php

namespace Yacare\InspeccionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RelevamientoIncidente
 *
 * @ORM\Table("Inspeccion_RelevamientoResultado")
 * @ORM\Entity
 */
class RelevamientoResultado
{
    use \Yacare\BaseBundle\Entity\ConId;
    use \Yacare\BaseBundle\Entity\ConNombre;
    use \Yacare\BaseBundle\Entity\Timestampable;
    use \Yacare\BaseBundle\Entity\Versionable;
    use \Yacare\BaseBundle\Entity\Eliminable;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Grupo;

    public function getGrupo() {
        return $this->Grupo;
    }

    public function setGrupo($Grupo) {
        $this->Grupo = $Grupo;
    }
    
    public function __toString() {
        if($this->getGrupo())
            return $this->getGrupo() . ': ' . $this->getNombre();
        else
            return $this->getNombre();
    }
}
