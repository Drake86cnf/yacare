<?php

namespace Yacare\ExpedientesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\ExpedientesBundle\Entity\Expediente
 *
 * @ORM\Entity
 * @ORM\Table(name="Expedientes_Expediente")
 */
class Expediente {
    use \Yacare\BaseBundle\Entity\ConId;
    use \Yacare\BaseBundle\Entity\ConNombre;
    use \Yacare\BaseBundle\Entity\ConObs;
    use \Yacare\BaseBundle\Entity\Versionable;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;

    /**
     * @ORM\ManyToOne(targetEntity="Yacare\OrganizacionBundle\Entity\Departamento")
     */
    protected $Ubicacion;
    
    public function getUbicacion() {
        return $this->Ubicacion;
    }

    public function setUbicacion($Ubicacion) {
        $this->Ubicacion = $Ubicacion;
    }
}