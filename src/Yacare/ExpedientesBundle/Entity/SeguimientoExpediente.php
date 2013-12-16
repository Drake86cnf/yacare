<?php

namespace Yacare\ExpedientesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\ExpedientesBundle\Entity\SeguimientoExpediente
 *
 * @ORM\Entity
 * @ORM\Table(name="Expedientes_SeguimientoExpediente")
 */
class SeguimientoExpediente {
    use \Yacare\BaseBundle\Entity\ConId;
    use \Yacare\ExpedientesBundle\Entity\ConExpediente;
    use \Yacare\BaseBundle\Entity\ConObs;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    
}