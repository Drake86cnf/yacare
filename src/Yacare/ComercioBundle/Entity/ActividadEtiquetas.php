<?php
namespace Yacare\ComercioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * La clase representa las  etiquetas (requisitos) que se asocian a una
 * actividad comercial.
 * 
 * @author Diaz Alejandro <alediaz.rc@gmail.com>
 *
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Table(name="Comercio_ActividadEtiquetas")
 */
class ActividadEtiquetas
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Tapir\BaseBundle\Entity\ConNombre;
    use \Tapir\BaseBundle\Entity\Versionable;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    use \Tapir\BaseBundle\Entity\ConObs;
}
