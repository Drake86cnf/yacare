<?php

namespace Yacare\ComercioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Yacare\BaseBundle\Model\Tree;

/**
 * Yacare\ComercioBundle\Entity\Actividad
 *
 * @ORM\Entity(repositoryClass="Yacare\BaseBundle\Entity\YacareBaseRepository")
 * @ORM\Table(name="Comercio_Actividad")
 */
class Actividad implements Tree\NodeInterface
{
    use \Yacare\BaseBundle\Entity\ConId;
    use \Yacare\BaseBundle\Entity\ConNombre;
    use \Yacare\BaseBundle\Entity\Versionable;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    use \Yacare\BaseBundle\Model\Tree\Node;
    
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true, length=50)
     */
    private $Clanae1997;
    
    /**
     * @ORM\ManyToOne(targetEntity="Actividad")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $ParentNode;
    
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true, length=50)
     */
    private $Clanae2010;
    
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true, length=50)
     * 
     * RG 3537/13 AFIP
     */
    private $ClaeAfip;
    
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true, length=50)
     * 
     * Ley 854/11 DGR-TDF
     */
    private $DgrTdf;
    
    /**
     * @ORM\Column(type="string", nullable=true, length=50)
     * Los códigos Clamae2014 tienen el siguiente formato: CDDGCSMM
     *      C   Categoría, alfabética
     *      DD  División, numérica
     *      G   Grupo, numérico
     *      C   Clase, numérica
     *      S   Sub-clase, numérica
     *      MM  Subdivisión del Municipio de Río Grande
     * 
     *      Por ejemplo: R9521000
     */
    private $Clamae2014;

     /**
     * @var integer
     * @ORM\Column(type="integer", nullable=true)
     */
    private $CategoriaAntigua;
    
    /**
     * @ORM\Column(type="string", nullable=true, length=50)
     */
    private $CodigoCpu;
    
    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    private $RequiereDbeh;
    
    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    private $RequiereDeyma;
    
     /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    private $Exento;
    
    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    private $Ley105;
    
    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $Incluye;
    
    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $NoIncluye;
    
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true, length=255)
     */
    private $Instructivos;
    
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true, length=5)
     */
    private $Categoria;
    
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true, length=5)
     */
    private $Division;
    
    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $Final;
    
    
    static public function NombresCategorias($categoria = null) {
        switch($categoria) {
            case 'I': return 'Actividad primaria';
            case 'II': return 'Actividad secundaria: Industria';
            case 'III': return 'Actividad secundaria: Servicios';
            case 'IV': return 'Actividad terciaria: Venta';
            case 'V': return 'Actividad terciaria: Servicios';
            default: return $categoria;
        }
    }
    
    public function getCategoriaNombre() {
        return static::NombresCategorias($this->getCategoria());
    }
    
    
    /*
     * Devuelve el "bread crumb" de la actividad actual
     */
    public function getRuta() {
        $res = '';
        $par = $this;
        while($par = $par->getParentNode()) {
            if(strcmp($par->__toString(), $this->__toString()) !== 0) {
                if($res) {
                    $res = $par->__toString() . ' <i class="fa fa-angle-right"></i> ' . $res;
                } else {
                    $res = $par->__toString();
                }
            }
        }
        return $res;
    }
    
    
    public static function getMaterializedPathMaterial()
    {
        return 'Clamae2014';
    }
    
    public function getSangria($sangria = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;') {
        $sang = substr_count($this->getMaterializedPath(), '/') - 1;
        return str_repeat($sangria, $sang > 0 ? $sang : 0);
    }
    
    
    public function getNombreConSangriaDeEspaciosDuros() {
        // Atención, los de la siguiente línea son 'espacios duros' (no se consolidan en el navegador)
        return $this->getSangria('   ') . $this->getNombre();
    }
    
    public function setClamae2014($Clamae2014) {
        $this->Clamae2014 = $Clamae2014;
        $this->Clanae2010 = substr($this->Clamae2014, 0, 6);
    }
    
    public function getClamae2014() {
        return $this->Clamae2014;
    }
    
    
    
    
    public function getClanae1997() {
        return $this->Clanae1997;
    }

    public function getClanae2010() {
        return $this->Clanae2010;
    }

    public function getClaeAfip() {
        return $this->ClaeAfip;
    }

    public function getDgrTdf() {
        return $this->DgrTdf;
    }

    public function getCategoria() {
        return $this->Categoria;
    }

    public function getCodigoCpu() {
        return $this->CodigoCpu;
    }

    public function getRequiereDbeh() {
        return $this->RequiereDbeh;
    }

    public function getRequiereDeyma() {
        return $this->RequiereDeyma;
    }

    public function getExento() {
        return $this->Exento;
    }

    public function getLey105() {
        return $this->Ley105;
    }

    public function getIncluye() {
        return $this->Incluye;
    }

    public function getNoIncluye() {
        return $this->NoIncluye;
    }

    public function getInstructivos() {
        return $this->Instructivos;
    }

    public function setClanae1997($Clanae1997) {
        $this->Clanae1997 = $Clanae1997;
    }

    public function setClanae2010($Clanae2010) {
        $this->Clanae2010 = $Clanae2010;
    }

    public function setClaeAfip($ClaeAfip) {
        $this->ClaeAfip = $ClaeAfip;
    }

    public function setDgrTdf($DgrTdf) {
        $this->DgrTdf = $DgrTdf;
    }

    public function setCategoria($Categoria) {
        $this->Categoria = $Categoria;
    }

    public function setCodigoCpu($CodigoCpu) {
        $this->CodigoCpu = $CodigoCpu;
    }

    public function setRequiereDbeh($RequiereDbeh) {
        $this->RequiereDbeh = $RequiereDbeh;
    }

    public function setRequiereDeyma($RequiereDeyma) {
        $this->RequiereDeyma = $RequiereDeyma;
    }

    public function setExento($Exento) {
        $this->Exento = $Exento;
    }

    public function setLey105($Ley105) {
        $this->Ley105 = $Ley105;
    }

    public function setIncluye($Incluye) {
        $this->Incluye = $Incluye;
    }

    public function setNoIncluye($NoIncluye) {
        $this->NoIncluye = $NoIncluye;
    }

    public function setInstructivos($Instructivos) {
        $this->Instructivos = $Instructivos;
    }

    public function getCategoriaAntigua() {
        return $this->CategoriaAntigua;
    }

    public function setCategoriaAntigua($CategoriaAntigua) {
        $this->CategoriaAntigua = $CategoriaAntigua;
    }

    public function getDivision() {
        return $this->Division;
    }

    public function setDivision($Division) {
        $this->Division = $Division;
    }
    
    public function getParentNode() {
        return $this->ParentNode;
    }

    public function getFinal() {
        return $this->Final;
    }

    public function setParentNode($ParentNode) {
        $this->ParentNode = $ParentNode;
    }

    public function setFinal($Final) {
        $this->Final = $Final;
    }
}
