<?php

namespace Yacare\TramitesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\TramitesBundle\Entity\TramiteTipo
 *
 * @ORM\Entity
 * @ORM\Table(name="Tramites_TramiteTipo")
 */
class TramiteTipo
{
    use \Yacare\BaseBundle\Entity\ConId;
    use \Yacare\BaseBundle\Entity\ConNombre;
    use \Yacare\BaseBundle\Entity\ConObs;
    use \Yacare\BaseBundle\Entity\ConUrl;
    use \Yacare\BaseBundle\Entity\Versionable;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $Clase;
    
    
    
    public function getClase() {
        return $this->Clase;
    }

    public function setClase($Clase) {
        $this->Clase = $Clase;
    }
}
