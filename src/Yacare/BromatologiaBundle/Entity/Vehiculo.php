<?php

namespace Yacare\BromatologiaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\BromatologiaBundle\Entity\Vehiculo
 *
 * @ORM\Entity
 * @ORM\Table(name="Bromatologia_Vehiculo")
 */
class Vehiculo
{
    use \Yacare\BaseBundle\Entity\ConId;
    use \Yacare\BaseBundle\Entity\Versionable;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    
     /**
     * @ORM\ManyToOne(targetEntity="Yacare\BromatologiaBundle\Entity\Transporte")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $Transporte;
    
    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $Dominio;
    
    
    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $Marca;
    
    
    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $Modelo;
    
     /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $Ano;
    
    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $Peso;
    
     public function __toString() {
        return $this->getDominio();
    }
    
    public function getDominio() {
        return $this->Dominio;
    }

    public function setDominio($Dominio) {
        $this->Dominio = $Dominio;
    }

    public function getMarca() {
        return $this->Marca;
    }

    public function setMarca($Marca) {
        $this->Marca = $Marca;
    }

    public function getModelo() {
        return $this->Modelo;
    }

    public function setModelo($Modelo) {
        $this->Modelo = $Modelo;
    }

    public function getAno() {
        return $this->Ano;
    }

    public function setAno($Ano) {
        $this->Ano = $Ano;
    }

    public function getPeso() {
        return $this->Peso;
    }

    public function setPeso($Peso) {
        $this->Peso = $Peso;
    }

    public function getTransporte() {
        return $this->Transporte;
    }

    public function setTransporte($Transporte) {
        $this->Transporte = $Transporte;
    }


    
    }
