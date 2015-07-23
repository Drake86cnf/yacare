<?php
namespace Yacare\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Describe un país.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 *        
 *         @ORM\Table(name="Base_Pais")
 *         @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 */
class Pais
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Tapir\BaseBundle\Entity\ConNombre;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    use \Tapir\BaseBundle\Entity\Versionable;

    /**
     * El código ISO de país.
     *
     * http://en.wikipedia.org/wiki/ISO_3166-1_alpha-2
     *
     * @var string $Iso
     *      @ORM\Column(type="string", length=2)
     */
    private $Iso;

    /**
     *
     * @ignore
     *
     */
    public function getIso()
    {
        return $this->Iso;
    }

    /**
     *
     * @ignore
     *
     */
    public function setIso($Iso)
    {
        $this->Iso = $Iso;
    }
}
