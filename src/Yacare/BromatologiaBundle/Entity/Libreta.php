<?php

namespace Yacare\BromatologiaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\BromatologiaBundle\Entity\Libreta
 *
 * @ORM\Entity
 * @ORM\Table(name="Bromatologia_Libreta")
 */
class Libreta
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
    protected $Persona;
   
    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $FechaCertificado;
    
    /**
     * @ORM\ManyToOne(targetEntity="Yacare\BromatologiaBundle\Entity\Medico")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $Profesional;
    
    /**
     * @ORM\ManyToOne(targetEntity="Yacare\BromatologiaBundle\Entity\CertificadoBpm")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $Curso;
    
      public function __toString() {
        return $this->getPersona()->getNombreVisible();
      }
    
    public function getPersona() {
        return $this->Persona;
    }

    public function setPersona($Persona) {
        $this->Persona = $Persona;
    }

    public function getFechaCertificado() {
        return $this->FechaCertificado;
    }

    public function setFechaCertificado(\DateTime $FechaCertificado) {
        $this->FechaCertificado = $FechaCertificado;
    }

    public function getProfesional() {
        return $this->Profesional;
    }

    public function setProfesional($Profesional) {
        $this->Profesional = $Profesional;
    }

    public function getCurso() {
        return $this->Curso;
    }

    public function setCurso($Curso) {
        $this->Curso = $Curso;
    }
 
}
