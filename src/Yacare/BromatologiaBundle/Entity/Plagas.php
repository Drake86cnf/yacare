<?php

namespace Yacare\BromatologiaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\BromatologiaBundle\Entity\Plagas
 *
 * @ORM\Entity
 * @ORM\Table(name="Bromatologia_Plagas")
 */
class Plagas
{
    use \Yacare\BaseBundle\Entity\ConId;
    use \Yacare\BaseBundle\Entity\ConDomicilio;
    use \Yacare\BaseBundle\Entity\Versionable;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    
    
    /**
     * @ORM\ManyToOne(targetEntity="Yacare\BaseBundle\Entity\Persona")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $Titular;
    
     public function __toString() {
        return $this->getDomicilio();
    }
    
    
    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $Tipolugar;
    
    public function getTitular() {
        return $this->Titular;
    }

    public function setTitular($Titular) {
        $this->Titular = $Titular;
    }

    public function getTipolugar() {
        return $this->Tipolugar;
    }

    public function setTipolugar($Tipolugar) {
        $this->Tipolugar = $Tipolugar;
    }


    
    }
