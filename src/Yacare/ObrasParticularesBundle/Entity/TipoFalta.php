<?php
namespace Yacare\ObrasParticularesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Representa una falta tipificada que por la cual se puede labrar un acta.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 *
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Table(name="ObrasParticulares_TipoFalta")
 */
class TipoFalta
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Tapir\BaseBundle\Entity\ConNombre;
    use \Tapir\BaseBundle\Entity\Versionable;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    
    /**
     * Representa el compromiso asumido, en base a la falta cometida.
     * 
     * @var string
     * 
     * @ORM\Column(type="string", nullable=false)
     */
    private $FaltaCompromiso;

    /**
     * @ignore
     */
    public function getFaltaCompromiso()
    {
        return $this->FaltaCompromiso;
    }

    /**
     * @ignore
     */
    public function setFaltaCompromiso($FaltaCompromiso)
    {
        $this->FaltaCompromiso = $FaltaCompromiso;
        return $this;
    }
}
