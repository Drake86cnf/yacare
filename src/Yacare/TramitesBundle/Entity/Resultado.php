<?php
namespace Yacare\TramitesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\TramitesBundle\Entity\Resultado
 *
 * @ORM\Table(name="Tramites_Resultado")
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 */
class Resultado
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Tapir\BaseBundle\Entity\ConNombre;
    use \Tapir\BaseBundle\Entity\Versionable;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
}
