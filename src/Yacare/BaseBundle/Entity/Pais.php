<?php

namespace Yacare\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\BaseBundle\Entity\Pais
 *
 * @ORM\Table(name="Base_Pais")
 * @ORM\Entity(repositoryClass="Yacare\BaseBundle\Entity\YacareBaseRepository")
 */
class Pais
{
    use \Yacare\BaseBundle\Entity\ConId;
    use \Yacare\BaseBundle\Entity\ConNombre;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    use \Yacare\BaseBundle\Entity\Versionable;
        
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
