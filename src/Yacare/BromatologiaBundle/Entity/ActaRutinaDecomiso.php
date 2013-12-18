<?php

namespace Yacare\BromatologiaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\BromatologiaBundle\Entity\ActaRutinaDecomiso
 *
 * @ORM\Entity(repositoryClass="Yacare\BaseBundle\Entity\YacareBaseRepository")
 * @ORM\Table(name="Bromatologia_ActaRutinaDecomiso")
 */
class ActaRutinaDecomiso extends \Yacare\BromatologiaBundle\Entity\ActaRutina
{
    
    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $NotaNumero;
    
    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $Huevo;
    
    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $Carne;
    
    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $Grasa;
    
    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $Mar;
    
    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $Embutido;
    
    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $Chacinado;
    
    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $Fiambre;
    
    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $Lacteo;
    
    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $Verdura;
    
    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $Fruta;
    
    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $Papa;
    
    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $Almacen;
    
    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $Cerdo;
    
    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $Pan;
    
    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $Ave;
    
    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $Bebida;
 
    public function getNotaNumero() {
        return $this->NotaNumero;
    }

    public function setNotaNumero($NotaNumero) {
        $this->NotaNumero = $NotaNumero;
    }
    
    public function getHuevo() {
        return $this->Huevo;
    }

    public function getCarne() {
        return $this->Carne;
    }

    public function getGrasa() {
        return $this->Grasa;
    }

    public function getMar() {
        return $this->Mar;
    }

    public function getEmbutido() {
        return $this->Embutido;
    }

    public function getChacinado() {
        return $this->Chacinado;
    }

    public function getFiambre() {
        return $this->Fiambre;
    }

    public function getLacteo() {
        return $this->Lacteo;
    }

    public function getVerdura() {
        return $this->Verdura;
    }

    public function getFruta() {
        return $this->Fruta;
    }

    public function getPapa() {
        return $this->Papa;
    }

    public function getAlmacen() {
        return $this->Almacen;
    }

    public function getCerdo() {
        return $this->Cerdo;
    }

    public function getPan() {
        return $this->Pan;
    }

    public function getAve() {
        return $this->Ave;
    }

    public function getBebida() {
        return $this->Bebida;
    }

    public function setHuevo($Huevo) {
        $this->Huevo = $Huevo;
    }

    public function setCarne($Carne) {
        $this->Carne = $Carne;
    }

    public function setGrasa($Grasa) {
        $this->Grasa = $Grasa;
    }

    public function setMar($Mar) {
        $this->Mar = $Mar;
    }

    public function setEmbutido($Embutido) {
        $this->Embutido = $Embutido;
    }

    public function setChacinado($Chacinado) {
        $this->Chacinado = $Chacinado;
    }

    public function setFiambre($Fiambre) {
        $this->Fiambre = $Fiambre;
    }

    public function setLacteo($Lacteo) {
        $this->Lacteo = $Lacteo;
    }

    public function setVerdura($Verdura) {
        $this->Verdura = $Verdura;
    }

    public function setFruta($Fruta) {
        $this->Fruta = $Fruta;
    }

    public function setPapa($Papa) {
        $this->Papa = $Papa;
    }

    public function setAlmacen($Almacen) {
        $this->Almacen = $Almacen;
    }

    public function setCerdo($Cerdo) {
        $this->Cerdo = $Cerdo;
    }

    public function setPan($Pan) {
        $this->Pan = $Pan;
    }

    public function setAve($Ave) {
        $this->Ave = $Ave;
    }

    public function setBebida($Bebida) {
        $this->Bebida = $Bebida;
    }

}
