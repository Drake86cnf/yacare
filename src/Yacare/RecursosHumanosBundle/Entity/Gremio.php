<?php
namespace Yacare\RecursosHumanosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Representa un gremio.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 * 
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Table(name="Rrhh_Gremio")
 */
class Gremio
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Tapir\BaseBundle\Entity\ConNombre;
    use \Tapir\BaseBundle\Entity\ConObs;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    use \Tapir\BaseBundle\Entity\Versionable;
    use \Tapir\BaseBundle\Entity\Suprimible;
}
