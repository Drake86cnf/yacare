<?php

namespace Yacare\ZoonosisBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\ZoonosisBundle\Entity\Veterinario
 *
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Table(name="Zoonosis_Veterinario")
 */
class Veterinario
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Tapir\BaseBundle\Entity\Versionable;
    use \Tapir\BaseBundle\Entity\Suprimible;
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
     * @ORM\ManyToOne(targetEntity="Yacare\ComercioBundle\Entity\CertificadoHabilitacionComercial")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $Clinica;
    
    
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
