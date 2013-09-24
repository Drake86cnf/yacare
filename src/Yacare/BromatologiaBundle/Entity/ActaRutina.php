<?php

namespace Yacare\BromatologiaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\BromatologiaBundle\Entity\ActaRutina
 *
 * @ORM\Entity
 * @ORM\Table(name="Bromatologia_ActaRutina")
 */
class ActaRutina extends \Yacare\InspeccionBundle\Entity\Acta
{
      /**
     * @ORM\ManyToOne(targetEntity="Yacare\ComercioBundle\Entity\Comercio")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $Comercio;
    
    /**
     * @ORM\ManyToOne(targetEntity="Yacare\BaseBundle\Entity\Persona")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $Persona; 
    
    public function getComercio() {
        return $this->Comercio;
    }

    public function setComercio($Comercio) {
        $this->Comercio = $Comercio;
    }

    public function getPersona() {
        return $this->Persona;
    }

    public function setPersona($Persona) {
        $this->Persona = $Persona;
    }    
}
