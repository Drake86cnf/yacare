<?php

namespace Yacare\CatastroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\CatastroBundle\Entity\Calle
 *
 * @ORM\Table(name="Catastro_Calle")
 * @ORM\Entity
 */
class Calle
{
    use \Yacare\BaseBundle\Entity\ConId;
    use \Yacare\BaseBundle\Entity\ConNombre;
    use \Yacare\BaseBundle\Entity\Versionable;
    use \Yacare\BaseBundle\Entity\Importable;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    
    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $NombreOriginal;
    
    public function getNombreOriginal() {
        return $this->NombreOriginal;
    }

    public function setNombreOriginal($NombreOriginal) {
        $this->NombreOriginal = $NombreOriginal;
    }
}
