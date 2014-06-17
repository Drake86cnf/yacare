<?php

namespace Yacare\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\BaseBundle\Entity\Pais
 *
 * @ORM\Table(name="Base_Pais")
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 */
class Pais
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Tapir\BaseBundle\Entity\ConNombre;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    use \Tapir\BaseBundle\Entity\Versionable;
        
    /**
     * @var string $Iso
     * @ORM\Column(type="string", length=2)
     */
    private $Iso;

    public function getIso() {
        return $this->Iso;
    }

    public function setIso($Iso) {
        $this->Iso = $Iso;
    }
}
