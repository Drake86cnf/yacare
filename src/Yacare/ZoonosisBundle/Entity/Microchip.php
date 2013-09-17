<?php

namespace Yacare\ZoonosisBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\ZoonosisBundle\Entity\Microchip
 *
 * @ORM\Entity
 * @ORM\Table(name="Zoonosis_Microchip")
 */
class Microchip
{
    use \Yacare\BaseBundle\Entity\ConId;
    use \Yacare\BaseBundle\Entity\ConNombre;
    use \Yacare\BaseBundle\Entity\ConDomicilio;    
    use \Yacare\BaseBundle\Entity\Versionable;
    use \Yacare\BaseBundle\Entity\Suprimible;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    
    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $Microchip;
    
    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $FechaAplicacion;
    
    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $TipoAnimal;
    
    
     public function getTipoAnimalNombre() {
        switch ($this->TipoAnimal){
            case 1:
                return 'Perro';
            case 2:
                return 'Gato';
            case 3:
                return 'Caballo';
            default:
                return '???';
        }
    }
    
     /**
     * @ORM\ManyToOne(targetEntity="Yacare\ZoonosisBundle\Entity\Raza")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $Raza;
    
     /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $Sexo;
    
    
     public function getSexoNombre() {
        switch ($this->Sexo){
            case 1:
                return 'Macho';
            case 2:
                return 'Hembra';
            default:
                return '???';
        }
    }
    
    
     /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $Estado;
    
    
     public function getEstadoNombre() {
        switch ($this->Estado){
            case 1:
                return 'Fertil';
            case 2:
                return 'Operado';
            default:
                return '???';
        }
    }
    
    
     /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $Pelaje;
    
    
     public function getPelajeNombre() {
        switch ($this->Pelaje){
            case 1:
                return 'Corto';
            case 2:
                return 'Mediano';
            case 3:
                return 'Largo';
            default:
                return '???';
        }
    }
        
    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $Color;
    
    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $Peso;
    
    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $FechaNacimiento;
    
        /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $Origen;
    
    
     public function getOrigenNombre() {
        switch ($this->Origen){
            case 1:
                return 'Compra';
            case 2:
                return 'Regalo';
            case 3:
                return 'Adopcion';
            default:
                return '???';
        }
    }
        
    
    /**
     * @ORM\ManyToOne(targetEntity="Yacare\BaseBundle\Entity\Persona")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $Dueno;
    
    /**
     * @ORM\ManyToOne(targetEntity="Yacare\BaseBundle\Entity\Persona")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $ContactoAlternativo;
    
     /**
     * @ORM\ManyToOne(targetEntity="Yacare\ZoonosisBundle\Entity\Veterinario")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $Veterinario;
    
      
     /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $Cerco;
    
    
     public function getCercoNombre() {
        switch ($this->Cerco){
            case 1:
                return 'Ninguno';
            case 2:
                return 'Parcial';
            case 3:
                return 'Total';
            default:
                return '???';
        }
    }
        
   
    public function getMicrochip() {
        return $this->Microchip;
    }

    public function setMicrochip($Microchip) {
        $this->Microchip = $Microchip;
    }

    public function getFechaAplicacion() {
        return $this->FechaAplicacion;
    }

    public function setFechaAplicacion(\DateTime $FechaAplicacion) {
        $this->FechaAplicacion = $FechaAplicacion;
    }

    public function getTipoAnimal() {
        return $this->TipoAnimal;
    }

    public function setTipoAnimal($TipoAnimal) {
        $this->TipoAnimal = $TipoAnimal;
    }

    public function getRaza() {
        return $this->Raza;
    }

    public function setRaza($Raza) {
        $this->Raza = $Raza;
    }

    public function getSexo() {
        return $this->Sexo;
    }

    public function setSexo($Sexo) {
        $this->Sexo = $Sexo;
    }

    public function getEstado() {
        return $this->Estado;
    }

    public function setEstado($Estado) {
        $this->Estado = $Estado;
    }

    public function getPelaje() {
        return $this->Pelaje;
    }

    public function setPelaje($Pelaje) {
        $this->Pelaje = $Pelaje;
    }

    public function getColor() {
        return $this->Color;
    }

    public function setColor($Color) {
        $this->Color = $Color;
    }

    public function getPeso() {
        return $this->Peso;
    }

    public function setPeso($Peso) {
        $this->Peso = $Peso;
    }

    public function getFechaNacimiento() {
        return $this->FechaNacimiento;
    }

    public function setFechaNacimiento(\DateTime $FechaNacimiento) {
        $this->FechaNacimiento = $FechaNacimiento;
    }

    public function getDueno() {
        return $this->Dueno;
    }

    public function setDueno($Dueno) {
        $this->Dueno = $Dueno;
    }

    public function getContactoAlternativo() {
        return $this->ContactoAlternativo;
    }

    public function setContactoAlternativo($ContactoAlternativo) {
        $this->ContactoAlternativo = $ContactoAlternativo;
    }

    public function getOrigen() {
        return $this->Origen;
    }

    public function setOrigen($Origen) {
        $this->Origen = $Origen;
    }

    public function getCerco() {
        return $this->Cerco;
    }

    public function setCerco($Cerco) {
        $this->Cerco = $Cerco;
    }

    public function getVeterinario() {
        return $this->Veterinario;
    }

    public function setVeterinario($Veterinario) {
        $this->Veterinario = $Veterinario;
    }


}
