<?php
namespace Yacare\CatastroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\CatastroBundle\Entity\Calle
 *
 * @ORM\Table(name="Catastro_Calle",
 *      indexes={
 *          @ORM\Index(name="Catastro_Calle_Nombre", columns={"nombre"})
 *      })
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 */
class Calle
{
    use\Tapir\BaseBundle\Entity\ConId;
    use\Tapir\BaseBundle\Entity\ConNombre;
    use\Tapir\BaseBundle\Entity\Versionable;
    use\Tapir\BaseBundle\Entity\Importable;
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
