<?php

namespace Yacare\TramitesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\TramitesBundle\Entity\Formulario
 *
 * @ORM\Table(name="Tramites_Formulario")
 * @ORM\Entity
 */
class Formulario
{
    use \Yacare\BaseBundle\Entity\ConId;
    use \Yacare\BaseBundle\Entity\ConNombre;
    use \Yacare\BaseBundle\Entity\ConObs;
    use \Yacare\BaseBundle\Entity\Versionable;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;

    /**
     * @var string
     * @ORM\Column(type="string", length=50)
     */
    private $Codigo;
    
    public function getCodigo() {
        return $this->Codigo;
    }

    public function setCodigo($Codigo) {
        $this->Codigo = $Codigo;
    }
}
