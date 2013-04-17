<?php

namespace Yacare\CatastroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\CatastroBundle\Entity\Partida
 *
 * @ORM\Table(name="Catastro_Partida")
 * @ORM\Entity
 */
class Partida
{
    use \Yacare\BaseBundle\Entity\Importable;
    
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\id
     * @ORM\GeneratedValue(strategy="AUTO")
     * 
     */
    private $id;
    
    /**
     * @var string $Nombre
     *
     * @ORM\Column(type="string", length=255)
     */
    private $Nombre;

    /**
     * @var string $Seccion
     *
     * @ORM\Column(type="string", length=50)
     */
    private $Seccion;
    
    /**
     * @var string $MacizoAlfa
     *
     * @ORM\Column(type="string", length=50)
     */
    private $MacizoAlfa;
    
    /**
     * @var string $MacizoNum
     *
     * @ORM\Column(type="string", length=50)
     */
    private $MacizoNum;
    
    /**
     * @var string $ParcelaAlfa
     *
     * @ORM\Column(type="string", length=50)
     */
    private $ParcelaAlfa;
    
    /**
     * @var string $ParcelaNum
     *
     * @ORM\Column(type="string", length=50)
     */
    private $ParcelaNum;
  

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    
    public function getNombre() {
        $this->Nombre = "Sección " . $this->Seccion . ", macizo " . $this->MacizoAlfa . $this->MacizoNum . ", parcela " . $this->ParcelaAlfa . $this->ParcelaNum;
        return $this->Nombre;
    }

    public function setNombre($Nombre) {
        $this->Nombre = "Sección " . $this->Seccion . ", macizo " . $this->MacizoAlfa . $this->MacizoNum . ", parcela " . $this->ParcelaAlfa . $this->ParcelaNum;
    }

    public function getSeccion() {
        return $this->Seccion;
    }

    public function setSeccion($Seccion) {
        $this->Seccion = $Seccion;
    }

    public function getMacizoAlfa() {
        return $this->MacizoAlfa;
    }

    public function setMacizoAlfa($MacizoAlfa) {
        $this->MacizoAlfa = $MacizoAlfa;
    }

    public function getMacizoNum() {
        return $this->MacizoNum;
    }

    public function setMacizoNum($MacizoNum) {
        $this->MacizoNum = $MacizoNum;
    }

    public function getParcelaAlfa() {
        return $this->ParcelaAlfa;
    }

    public function setParcelaAlfa($ParcelaAlfa) {
        $this->ParcelaAlfa = $ParcelaAlfa;
    }

    public function getParcelaNum() {
        return $this->ParcelaNum;
    }

    public function setParcelaNum($ParcelaNum) {
        $this->ParcelaNum = $ParcelaNum;
    }

}
