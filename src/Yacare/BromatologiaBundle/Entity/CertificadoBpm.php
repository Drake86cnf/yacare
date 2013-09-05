<?php

namespace Yacare\BromatologiaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\BromatologiaBundle\Entity\CertificadoBpm
 *
 * @ORM\Entity
 * @ORM\Table(name="Bromatologia_CertificadoBpm")
 */
class CertificadoBpm
{
    use \Yacare\BaseBundle\Entity\ConId;
    use \Yacare\BaseBundle\Entity\Versionable;
    use \Yacare\BaseBundle\Entity\Suprimible;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    
    
    /**
     * @ORM\ManyToOne(targetEntity="Yacare\BaseBundle\Entity\Persona")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $Persona;
   
    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $FechaExamen;
    
        public function __toString() {
      return $this->getFechaExamen();
    }
      
    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $Nota;

    
    public function getPersona() {
        return $this->Persona;
    }

    public function setPersona($Persona) {
        $this->Persona = $Persona;
    }

    public function getFechaExamen() {
        return $this->FechaExamen;
    }

    public function setFechaExamen(\DateTime $FechaExamen) {
        $this->FechaExamen = $FechaExamen;
    }

    public function getNota() {
        return $this->Nota;
    }

    public function setNota($Nota) {
        $this->Nota = $Nota;
    }

}
