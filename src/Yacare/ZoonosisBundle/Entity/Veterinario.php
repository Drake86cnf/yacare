<?php

namespace Yacare\ZoonosisBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\ZoonosisBundle\Entity\Veterinario
 *
 * @ORM\Entity
 * @ORM\Table(name="Zoonosis_Veterinario")
 */
class Veterinario
{
    use \Yacare\BaseBundle\Entity\ConId;
    use \Yacare\BaseBundle\Entity\ConDomicilio;
    use \Yacare\BaseBundle\Entity\Versionable;
    use \Yacare\BaseBundle\Entity\Suprimible;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    
    
    /**
     * @ORM\ManyToOne(targetEntity="Yacare\BaseBundle\Entity\Persona")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $Veterinario;
   
    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $Matricula;
    
    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Clinica;
    
    
      public function __toString() {
        return $this->getVeterinario()->getNombreVisible();
    }
      
    
    
    public function getVeterinario() {
        return $this->Veterinario;
    }

    public function setVeterinario($Veterinario) {
        $this->Veterinario = $Veterinario;
    }

    public function getMatricula() {
        return $this->Matricula;
    }

    public function setMatricula($Matricula) {
        $this->Matricula = $Matricula;
    }

    public function getClinica() {
        return $this->Clinica;
    }

    public function setClinica($Clinica) {
        $this->Clinica = $Clinica;
    }
    
   
}
