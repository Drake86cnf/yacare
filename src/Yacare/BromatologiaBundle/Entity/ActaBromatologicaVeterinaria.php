<?php

namespace Yacare\BromatologiaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\BromatologiaBundle\Entity\ActaBromatologicaVeterinaria
 *
 * @ORM\Entity
 * @ORM\Table(name="Bromatologia_ActaBromatologicaVeterinaria")
 */
class ActaBromatologicaVeterinaria extends \Yacare\InspeccionBundle\Entity\Acta
{
    use \Yacare\BaseBundle\Entity\ConDomicilio;
        
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
    
    /**
     * @ORM\ManyToOne(targetEntity="Yacare\ComercioBundle\Entity\Comercio")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $Transporte;
    
    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $Dominio;
    
    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $GuiaRemovido;
    
    
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

    public function getTransporte() {
        return $this->Transporte;
    }

    public function setTransporte($Transporte) {
        $this->Transporte = $Transporte;
    }

    public function getDominio() {
        return $this->Dominio;
    }

    public function setDominio($Dominio) {
        $this->Dominio = $Dominio;
    }

    public function getGuiaRemovido() {
        return $this->GuiaRemovido;
    }

    public function setGuiaRemovido($GuiaRemovido) {
        $this->GuiaRemovido = $GuiaRemovido;
    }
}
