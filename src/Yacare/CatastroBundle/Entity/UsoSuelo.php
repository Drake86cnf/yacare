<?php
namespace Yacare\CatastroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Representa el UsoSuelo.
 *
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Table(name="Catastro_UsoSuelo", indexes={
 *     @ORM\Index(name="Catastro_UsoSuelo_Codigo", columns={"Codigo"})
 * })
 */
class UsoSuelo
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Tapir\BaseBundle\Entity\ConNombre;
    use \Tapir\BaseBundle\Entity\Versionable;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    
    /**
     * La categoría.
     * 
     * @var string
     * 
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $Categoria;
    
    /**
     * La sección.
     * 
     * @var string
     * 
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Seccion;
    
    /**
     * El código.
     * 
     * @var integer
     * 
     * @ORM\Column(type="integer")
     */
    private $Codigo;
    
    /**
     * La superficie máxima.
     * 
     * @var integer
     * 
     * @ORM\Column(type="integer")
     */
    private $SuperficieMaxima;
    
    /**
     * @var integer
     * 
     * @ORM\Column(type="integer")
     */
    private $UsoZona1;
    
    /**
     * @var integer
     * 
     * @ORM\Column(type="integer")
     */
    private $UsoZona2;
    
    /**
     * @var integer
     * 
     * @ORM\Column(type="integer")
     */
    private $UsoZona3;
    
    /**
     * @var integer
     * 
     * @ORM\Column(type="integer")
     */
    private $UsoZona4;
    
    /**
     * @var integer
     * 
     * @ORM\Column(type="integer")
     */
    private $UsoZona5;
    
    /**
     * @var integer
     * 
     * @ORM\Column(type="integer")
     */
    private $UsoZona6;
    
    /**
     * @var integer
     * 
     * @ORM\Column(type="integer")
     */
    private $UsoZona7;
    
    /**
     * @var integer
     * 
     * @ORM\Column(type="integer")
     */
    private $UsoZona8;
    
    /**
     * @var integer
     * 
     * @ORM\Column(type="integer")
     */
    private $UsoZona9;
    
    /**
     * @var integer
     * 
     * @ORM\Column(type="integer")
     */
    private $UsoZona10;
    
    /**
     * @var integer
     * 
     * @ORM\Column(type="integer")
     */
    private $UsoZona11;
    
    /**
     * @var integer
     * 
     * @ORM\Column(type="integer")
     */
    private $UsoZona12;
    
    /**
     * @var integer
     * 
     * @ORM\Column(type="integer")
     */
    private $UsoZona13;
    
    /**
     * @var integer
     * 
     * @ORM\Column(type="integer")
     */
    private $UsoZona14;
    
    /**
     * @var integer
     * 
     * @ORM\Column(type="integer")
     */
    private $UsoZona15;
    
    /**
     * @var integer
     * 
     * @ORM\Column(type="integer")
     */
    private $UsoZona16;
    
    /**
     * @var integer
     * 
     * @ORM\Column(type="integer")
     */
    private $UsoZona17;
    
    /**
     * @var integer
     * 
     * @ORM\Column(type="integer")
     */
    private $UsoZona18;
    
    /**
     * @var integer
     * 
     * @ORM\Column(type="integer")
     */
    private $UsoZona19;
    
    /**
     * @var integer
     * 
     * @ORM\Column(type="integer")
     */
    private $UsoZona20;

    /**
     * Normaliza el nombre de UsoSuelo.
     * 
     * @param  integer $numero rango de clasificación.
     * @return string
     */
    public static function UsoSueloNombre($numero)
    {
        switch ($numero) {
            case 1:
                return 'Predominante';
            case 2:
                return 'Compatible';
            case 3:
                return 'Condicional';
            case 9:
                return 'Prohibido';
            default:
                return 'Desconocido';
        }
    }

    /**
     * Getter grupal que identifica y devuelve la zona correspondiente.
     * 
     * @param  Zona $zona
     * @return Zona
     */
    public function getUsoZona($zona)
    {
        switch ($zona) {
            case 1:
                return $this->getUsoZona1();
            case 2:
                return $this->getUsoZona2();
            case 3:
                return $this->getUsoZona3();
            case 4:
                return $this->getUsoZona4();
            case 5:
                return $this->getUsoZona5();
            case 6:
                return $this->getUsoZona6();
            case 7:
                return $this->getUsoZona7();
            case 8:
                return $this->getUsoZona8();
            case 9:
                return $this->getUsoZona9();
            case 10:
                return $this->getUsoZona10();
            case 11:
                return $this->getUsoZona11();
            case 12:
                return $this->getUsoZona12();
            case 13:
                return $this->getUsoZona13();
            case 14:
                return $this->getUsoZona14();
            case 15:
                return $this->getUsoZona15();
            case 16:
                return $this->getUsoZona16();
            case 17:
                return $this->getUsoZona17();
            case 18:
                return $this->getUsoZona18();
            case 19:
                return $this->getUsoZona19();
            case 20:
                return $this->getUsoZona20();
        }
    }

    /**
     * @ignore
     */
    public function getCategoria()
    {
        return $this->Categoria;
    }

    /**
     * @ignore
     */
    public function setCategoria($Categoria)
    {
        $this->Categoria = $Categoria;
        return $this;
    }

    /**
     * @ignore
     */
    public function getSeccion()
    {
        return $this->Seccion;
    }

    /**
     * @ignore
     */
    public function setSeccion($Seccion)
    {
        $this->Seccion = $Seccion;
        return $this;
    }

    /**
     * @ignore
     */
    public function getCodigo()
    {
        return $this->Codigo;
    }

    /**
     * @ignore
     */
    public function setCodigo($Codigo)
    {
        $this->Codigo = $Codigo;
        return $this;
    }

    /**
     * @ignore
     */
    public function getSuperficieMaxima()
    {
        return $this->SuperficieMaxima;
    }

    /**
     * @ignore
     */
    public function setSuperficieMaxima($SuperficieMaxima)
    {
        $this->SuperficieMaxima = $SuperficieMaxima;
        return $this;
    }

    /**
     * @ignore
     */
    public function getUsoZona1()
    {
        return $this->UsoZona1;
    }

    /**
     * @ignore
     */
    public function setUsoZona1($UsoZona1)
    {
        $this->UsoZona1 = $UsoZona1;
        return $this;
    }

    /**
     * @ignore
     */
    public function getUsoZona2()
    {
        return $this->UsoZona2;
    }

    /**
     * @ignore
     */
    public function setUsoZona2($UsoZona2)
    {
        $this->UsoZona2 = $UsoZona2;
        return $this;
    }

    /**
     * @ignore
     */
    public function getUsoZona3()
    {
        return $this->UsoZona3;
    }

    /**
     * @ignore
     */
    public function setUsoZona3($UsoZona3)
    {
        $this->UsoZona3 = $UsoZona3;
        return $this;
    }

    /**
     * @ignore
     */
    public function getUsoZona4()
    {
        return $this->UsoZona4;
    }

    /**
     * @ignore
     */
    public function setUsoZona4($UsoZona4)
    {
        $this->UsoZona4 = $UsoZona4;
        return $this;
    }

    /**
     * @ignore
     */
    public function getUsoZona5()
    {
        return $this->UsoZona5;
    }

    /**
     * @ignore
     */
    public function setUsoZona5($UsoZona5)
    {
        $this->UsoZona5 = $UsoZona5;
        return $this;
    }

    /**
     * @ignore
     */
    public function getUsoZona6()
    {
        return $this->UsoZona6;
    }

    /**
     * @ignore
     */
    public function setUsoZona6($UsoZona6)
    {
        $this->UsoZona6 = $UsoZona6;
        return $this;
    }

    /**
     * @ignore
     */
    public function getUsoZona7()
    {
        return $this->UsoZona7;
    }

    /**
     * @ignore
     */
    public function setUsoZona7($UsoZona7)
    {
        $this->UsoZona7 = $UsoZona7;
        return $this;
    }

    /**
     * @ignore
     */
    public function getUsoZona8()
    {
        return $this->UsoZona8;
    }

    /**
     * @ignore
     */
    public function setUsoZona8($UsoZona8)
    {
        $this->UsoZona8 = $UsoZona8;
        return $this;
    }

    /**
     * @ignore
     */
    public function getUsoZona9()
    {
        return $this->UsoZona9;
    }

    /**
     * @ignore
     */
    public function setUsoZona9($UsoZona9)
    {
        $this->UsoZona9 = $UsoZona9;
        return $this;
    }

    /**
     * @ignore
     */
    public function getUsoZona10()
    {
        return $this->UsoZona10;
    }

    /**
     * @ignore
     */
    public function setUsoZona10($UsoZona10)
    {
        $this->UsoZona10 = $UsoZona10;
        return $this;
    }

    /**
     * @ignore
     */
    public function getUsoZona11()
    {
        return $this->UsoZona11;
    }

    /**
     * @ignore
     */
    public function setUsoZona11($UsoZona11)
    {
        $this->UsoZona11 = $UsoZona11;
        return $this;
    }

    /**
     * @ignore
     */
    public function getUsoZona12()
    {
        return $this->UsoZona12;
    }

    /**
     * @ignore
     */
    public function setUsoZona12($UsoZona12)
    {
        $this->UsoZona12 = $UsoZona12;
        return $this;
    }

    /**
     * @ignore
     */
    public function getUsoZona13()
    {
        return $this->UsoZona13;
    }

    /**
     * @ignore
     */
    public function setUsoZona13($UsoZona13)
    {
        $this->UsoZona13 = $UsoZona13;
        return $this;
    }

    /**
     * @ignore
     */
    public function getUsoZona14()
    {
        return $this->UsoZona14;
    }

    /**
     * @ignore
     */
    public function setUsoZona14($UsoZona14)
    {
        $this->UsoZona14 = $UsoZona14;
        return $this;
    }

    /**
     * @ignore
     */
    public function getUsoZona15()
    {
        return $this->UsoZona15;
    }

    /**
     * @ignore
     */
    public function setUsoZona15($UsoZona15)
    {
        $this->UsoZona15 = $UsoZona15;
        return $this;
    }

    /**
     * @ignore
     */
    public function getUsoZona16()
    {
        return $this->UsoZona16;
    }

    /**
     * @ignore
     */
    public function setUsoZona16($UsoZona16)
    {
        $this->UsoZona16 = $UsoZona16;
        return $this;
    }

    /**
     * @ignore
     */
    public function getUsoZona17()
    {
        return $this->UsoZona17;
    }

    /**
     * @ignore
     */
    public function setUsoZona17($UsoZona17)
    {
        $this->UsoZona17 = $UsoZona17;
        return $this;
    }

    /**
     * @ignore
     */
    public function getUsoZona18()
    {
        return $this->UsoZona18;
    }

    /**
     * @ignore
     */
    public function setUsoZona18($UsoZona18)
    {
        $this->UsoZona18 = $UsoZona18;
        return $this;
    }

    /**
     * @ignore
     */
    public function getUsoZona19()
    {
        return $this->UsoZona19;
    }

    /**
     * @ignore
     */
    public function setUsoZona19($UsoZona19)
    {
        $this->UsoZona19 = $UsoZona19;
        return $this;
    }

    /**
     * @ignore
     */
    public function getUsoZona20()
    {
        return $this->UsoZona20;
    }

    /**
     * @ignore
     */
    public function setUsoZona20($UsoZona20)
    {
        $this->UsoZona20 = $UsoZona20;
        return $this;
    }
}
