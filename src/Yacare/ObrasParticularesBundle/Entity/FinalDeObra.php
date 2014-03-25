<?php

namespace Yacare\ObrasParticularesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\ObrasParticularesBundle\Entity\Calle
 *
 * @ORM\Table(name="ObrasParticulares_FinalDeObra")
 * @ORM\Entity(repositoryClass="Yacare\BaseBundle\Entity\YacareBaseRepository")
 */
class FinalDeObra
{
    use \Yacare\BaseBundle\Entity\ConId;
    //use \Yacare\BaseBundle\Entity\Versionable;
    //use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    
    /**
     * @ORM\Column(type="decimal", precision=14, scale=2, nullable=false)
     */
    private $Superficie;
}
