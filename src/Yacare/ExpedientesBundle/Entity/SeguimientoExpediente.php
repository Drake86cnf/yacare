<?php
namespace Yacare\ExpedientesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\ExpedientesBundle\Entity\SeguimientoExpediente
 *
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Table(name="Expedientes_SeguimientoExpediente")
 */
class SeguimientoExpediente
{
    use\Tapir\BaseBundle\Entity\ConId;
    use\Yacare\ExpedientesBundle\Entity\ConExpediente;
    use\Tapir\BaseBundle\Entity\ConObs;
    use\Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
}