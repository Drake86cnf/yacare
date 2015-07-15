<?php
namespace Yacare\RecursosHumanosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * Representa un cargo que puede tener un agente.
 *
 * @author Ernesto Carrea <equistango@gmail.com>
 *        
 * @ORM\Table(name="Rrhh_Cargo")
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 */
class Cargo
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Tapir\BaseBundle\Entity\ConNombre;
    use \Tapir\BaseBundle\Entity\ConObs;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    use \Tapir\BaseBundle\Entity\Versionable;
    use \Tapir\BaseBundle\Entity\Suprimible;
    
    /**
     * El historial de cargos asignados.
     * 
     * @ORM\OneToMany(targetEntity="Cargo", cascade={ "persist" })
     */
    private $Historial;
    
    public function __construct() {
        $this->Historial = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * @ignore
     */
    public function setHistorial($Historial) {
        return $this->Historial = $Historial;
    }
    
    /**
     * @ignore
     */
    public function getHistorial() {
        return $this->Historial;
    }
}
