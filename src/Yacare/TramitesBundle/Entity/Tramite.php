<?php

namespace Yacare\TramitesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\TramitesBundle\Entity\Tramite
 *
 * @ORM\Entity
 * @ORM\Table(name="Tramites_Tramite")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="TramiteTipo", type="string")
 * @ORM\DiscriminatorMap({"\Yacare\ComercioBundle\Entity\TramiteHabilitacionComercial" = "\Yacare\ComercioBundle\Entity\TramiteHabilitacionComercial"})
 */
class Tramite
{
    use \Yacare\BaseBundle\Entity\ConId;
    use \Yacare\BaseBundle\Entity\ConNombre;
    use \Yacare\BaseBundle\Entity\ConObs;
    use \Yacare\BaseBundle\Entity\Versionable;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;

    use \Yacare\TramitesBundle\Entity\ConTitular;
    
}
