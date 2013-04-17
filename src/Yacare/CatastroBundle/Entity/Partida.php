<?php

namespace Yacare\CatastroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\CatastroBundle\Entity\Partida
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Partida
{
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
