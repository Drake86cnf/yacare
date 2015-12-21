<?php
namespace Yacare\ObrasParticularesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Representa una previa.
 *
 * @author Ezequiel Riquelme <rezequiel.tdf@gmail.com>
 *
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Table(name="ObrasParticulares_Previa")
 */
class Previa
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Tapir\BaseBUndle\Entity\ConObs;
    use \Tapir\BaseBundle\Entity\Versionable;
    use \Yacare\BaseBundle\Entity\ConAdjuntos;
    use \Yacare\CatastroBundle\Entity\ConPartida;
    use \Yacare\ObrasParticularesBundle\Entity\ConProfesional;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
}
