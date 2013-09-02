<?php

namespace Yacare\BromatologiaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\BromatologiaBundle\Entity\Medico
 *
 * @ORM\Entity
 * @ORM\Table(name="Bromatologia_Medico")
 */
class Medico
{
    use \Yacare\BaseBundle\Entity\ConId;
    use \Yacare\BaseBundle\Entity\Versionable;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    
    
    /**
     * @ORM\ManyToOne(targetEntity="Yacare\BaseBundle\Entity\Persona")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $Titular;
   
    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $Matricula;
        
    public function getTitular() {
        return $this->Titular;
    }

    public function setTitular($Titular) {
        $this->Titular = $Titular;
    }

    public function getMatricula() {
        return $this->Matricula;
    }

    public function setMatricula($Matricula) {
        $this->Matricula = $Matricula;
    }


}
