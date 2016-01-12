<?php
namespace Yacare\NominaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Representa una etiqueta asociable a un inmueble.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 *
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Table(name="Nomina_InmuebleEtiqueta")
 */
class InmuebleEtiqueta
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Tapir\BaseBundle\Entity\ConNombre;
    use \Tapir\BaseBundle\Entity\ConObs;
    use \Tapir\BaseBundle\Entity\Versionable;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
}
