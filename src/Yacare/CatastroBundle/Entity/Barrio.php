<?php
namespace Yacare\CatastroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\CatastroBundle\Entity\Barrio
 *
 * @ORM\Table(name="Catastro_Barrio",
 *      indexes={
 *          @ORM\Index(name="Catastro_Barrio_Nombre", columns={"nombre"})
 *      })
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 */
class Barrio
{
    use\Tapir\BaseBundle\Entity\ConId;
    use\Tapir\BaseBundle\Entity\ConNombre;
    use\Tapir\BaseBundle\Entity\ConObs;
    use\Tapir\BaseBundle\Entity\ConNotas;
    use\Tapir\BaseBundle\Entity\Versionable;
    use\Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;

    /**
     *
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $NombreOriginal;

    public function getNombreOriginal()
    {
        return $this->NombreOriginal;
    }

    public function setNombreOriginal($NombreOriginal)
    {
        $this->NombreOriginal = $NombreOriginal;
    }
}
