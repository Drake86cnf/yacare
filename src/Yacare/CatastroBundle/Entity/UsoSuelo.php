<?php

namespace Yacare\CatastroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\CatastroBundle\Entity\UsoSuelo
 *
 * @ORM\Table(name="Catastro_UsoSuelo",
 *      indexes={
 *          @ORM\Index(name="Catastro_UsoSuelo_Codigo", columns={"Codigo"})
 *      }
 * )
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 */
class UsoSuelo
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Tapir\BaseBundle\Entity\ConNombre;
    use \Tapir\BaseBundle\Entity\Versionable;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $Categoria;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Seccion;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $Codigo;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $SuperficieMaxima;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $UsoZona1;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $UsoZona2;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $UsoZona3;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $UsoZona4;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $UsoZona5;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $UsoZona6;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $UsoZona7;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $UsoZona8;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $UsoZona9;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $UsoZona10;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $UsoZona11;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $UsoZona12;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $UsoZona13;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $UsoZona14;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $UsoZona15;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $UsoZona16;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $UsoZona17;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $UsoZona18;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $UsoZona19;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $UsoZona20;

    
    public static function UsoSueloNombre($numero) {
        switch($numero) {
            case 1: return 'Predominante';
            case 2: return 'Compatible';
            case 3: return 'Condicional';
            case 9: return 'Prohibido';
            default: return 'Desconocido';
        }
    }
    
    public function getUsoZona($zona) {
        switch($zona) {
            case 1: return $this->getUsoZona1();
            case 2: return $this->getUsoZona2();
            case 3: return $this->getUsoZona3();
            case 4: return $this->getUsoZona4();
            case 5: return $this->getUsoZona5();
            case 6: return $this->getUsoZona6();
            case 7: return $this->getUsoZona7();
            case 8: return $this->getUsoZona8();
            case 9: return $this->getUsoZona9();
            case 10: return $this->getUsoZona10();
            case 11: return $this->getUsoZona11();
            case 12: return $this->getUsoZona12();
            case 13: return $this->getUsoZona13();
            case 14: return $this->getUsoZona14();
            case 15: return $this->getUsoZona15();
            case 16: return $this->getUsoZona16();
            case 17: return $this->getUsoZona17();
            case 18: return $this->getUsoZona18();
            case 19: return $this->getUsoZona19();
            case 20: return $this->getUsoZona20();
        }
    }
    
    
    
    public function getCategoria() {
        return $this->Categoria;
    }

    public function getSeccion() {
        return $this->Seccion;
    }

    public function getCodigo() {
        return $this->Codigo;
    }

    public function getSuperficieMaxima() {
        return $this->SuperficieMaxima;
    }

    public function getUsoZona1() {
        return $this->UsoZona1;
    }

    public function getUsoZona2() {
        return $this->UsoZona2;
    }

    public function getUsoZona3() {
        return $this->UsoZona3;
    }

    public function getUsoZona4() {
        return $this->UsoZona4;
    }

    public function getUsoZona5() {
        return $this->UsoZona5;
    }

    public function getUsoZona6() {
        return $this->UsoZona6;
    }

    public function getUsoZona7() {
        return $this->UsoZona7;
    }

    public function getUsoZona8() {
        return $this->UsoZona8;
    }

    public function getUsoZona9() {
        return $this->UsoZona9;
    }

    public function getUsoZona10() {
        return $this->UsoZona10;
    }

    public function getUsoZona11() {
        return $this->UsoZona11;
    }

    public function getUsoZona12() {
        return $this->UsoZona12;
    }

    public function getUsoZona13() {
        return $this->UsoZona13;
    }

    public function getUsoZona14() {
        return $this->UsoZona14;
    }

    public function getUsoZona15() {
        return $this->UsoZona15;
    }

    public function getUsoZona16() {
        return $this->UsoZona16;
    }

    public function getUsoZona17() {
        return $this->UsoZona17;
    }

    public function getUsoZona18() {
        return $this->UsoZona18;
    }

    public function getUsoZona19() {
        return $this->UsoZona19;
    }

    public function getUsoZona20() {
        return $this->UsoZona20;
    }

    public function setCategoria($Categoria) {
        $this->Categoria = $Categoria;
    }

    public function setSeccion($Seccion) {
        $this->Seccion = $Seccion;
    }

    public function setCodigo($Codigo) {
        $this->Codigo = $Codigo;
    }

    public function setSuperficieMaxima($SuperficieMaxima) {
        $this->SuperficieMaxima = $SuperficieMaxima;
    }

    public function setUsoZona1($UsoZona1) {
        $this->UsoZona1 = $UsoZona1;
    }

    public function setUsoZona2($UsoZona2) {
        $this->UsoZona2 = $UsoZona2;
    }

    public function setUsoZona3($UsoZona3) {
        $this->UsoZona3 = $UsoZona3;
    }

    public function setUsoZona4($UsoZona4) {
        $this->UsoZona4 = $UsoZona4;
    }

    public function setUsoZona5($UsoZona5) {
        $this->UsoZona5 = $UsoZona5;
    }

    public function setUsoZona6($UsoZona6) {
        $this->UsoZona6 = $UsoZona6;
    }

    public function setUsoZona7($UsoZona7) {
        $this->UsoZona7 = $UsoZona7;
    }

    public function setUsoZona8($UsoZona8) {
        $this->UsoZona8 = $UsoZona8;
    }

    public function setUsoZona9($UsoZona9) {
        $this->UsoZona9 = $UsoZona9;
    }

    public function setUsoZona10($UsoZona10) {
        $this->UsoZona10 = $UsoZona10;
    }

    public function setUsoZona11($UsoZona11) {
        $this->UsoZona11 = $UsoZona11;
    }

    public function setUsoZona12($UsoZona12) {
        $this->UsoZona12 = $UsoZona12;
    }

    public function setUsoZona13($UsoZona13) {
        $this->UsoZona13 = $UsoZona13;
    }

    public function setUsoZona14($UsoZona14) {
        $this->UsoZona14 = $UsoZona14;
    }

    public function setUsoZona15($UsoZona15) {
        $this->UsoZona15 = $UsoZona15;
    }

    public function setUsoZona16($UsoZona16) {
        $this->UsoZona16 = $UsoZona16;
    }

    public function setUsoZona17($UsoZona17) {
        $this->UsoZona17 = $UsoZona17;
    }

    public function setUsoZona18($UsoZona18) {
        $this->UsoZona18 = $UsoZona18;
    }

    public function setUsoZona19($UsoZona19) {
        $this->UsoZona19 = $UsoZona19;
    }

    public function setUsoZona20($UsoZona20) {
        $this->UsoZona20 = $UsoZona20;
    }
}
