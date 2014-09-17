<?php
namespace Yacare\InspeccionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tipos de resultado.
 * 
 * @see RelevamientoAsignacionResultado
 * 
 * @author Ernesto Carrea <equistango@gmail.com>
 *
 * @ORM\Table("Inspeccion_RelevamientoResultado")
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 */
class RelevamientoResultado
{
    use\Tapir\BaseBundle\Entity\ConId;
    use\Tapir\BaseBundle\Entity\ConNombre;
    use\Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    use\Tapir\BaseBundle\Entity\Versionable;
    use\Tapir\BaseBundle\Entity\Suprimible;

    /**
     *
     * @var string @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Grupo;

    public function getGrupo()
    {
        return $this->Grupo;
    }

    public function setGrupo($Grupo)
    {
        $this->Grupo = $Grupo;
    }

    public function __toString()
    {
        if ($this->getGrupo())
            return $this->getGrupo() . ': ' . $this->getNombre();
        else
            return $this->getNombre();
    }
}
