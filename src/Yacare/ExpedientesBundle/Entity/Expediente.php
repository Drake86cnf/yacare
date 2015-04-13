<?php
namespace Yacare\ExpedientesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\ExpedientesBundle\Entity\Expediente
 *
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Table(name="Expedientes_Expediente")
 */
class Expediente
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Tapir\BaseBundle\Entity\ConNombre;
    use \Tapir\BaseBundle\Entity\ConObs;
    use \Tapir\BaseBundle\Entity\Versionable;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;

    /**
     * @ORM\ManyToOne(targetEntity="Yacare\OrganizacionBundle\Entity\Departamento")
     */
    protected $Ubicacion;

    public function getUbicacion()
    {
        return $this->Ubicacion;
    }

    public function setUbicacion($Ubicacion)
    {
        $this->Ubicacion = $Ubicacion;
    }
}