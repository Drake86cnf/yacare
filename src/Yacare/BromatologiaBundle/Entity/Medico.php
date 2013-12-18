<?php

namespace Yacare\BromatologiaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\BromatologiaBundle\Entity\Medico
 *
 * @ORM\Entity(repositoryClass="Yacare\BaseBundle\Entity\YacareBaseRepository")
 * @ORM\Table(name="Bromatologia_Medico")
 */
class Medico
{
    use \Yacare\BaseBundle\Entity\ConId;
    use \Yacare\BaseBundle\Entity\Versionable;
    use \Yacare\BaseBundle\Entity\Suprimible;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    
    
    /**
     * @ORM\ManyToOne(targetEntity="Yacare\BaseBundle\Entity\Persona")
     * @ORM\JoinColumn(nullable=true)
     * @ORM\OrderBy({ "NombreVisible" = "ASC" })
     */
    protected $Medico;
   
    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $Matricula;
    
    
      public function __toString() {
        return $this->getMedico()->getNombreVisible();
    }
        
    
    
    public function getMedico() {
        return $this->Medico;
    }

    public function setMedico($Medico) {
        $this->Medico = $Medico;
    }

    public function getMatricula() {
        return $this->Matricula;
    }

    public function setMatricula($Matricula) {
        $this->Matricula = $Matricula;
    }


}
