<?php
namespace Yacare\ComercioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Yacare\BaseBundle\Model\Tree;

/**
 * Representa una actividad económica, según ClaMAE 2014.
 *
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Table(name="Comercio_Actividad")
 */
class Actividad implements Tree\NodeInterface
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Tapir\BaseBundle\Entity\ConNombre;
    use \Tapir\BaseBundle\Entity\Versionable;
    use \Tapir\BaseBundle\Entity\Suprimible;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    use \Yacare\BaseBundle\Model\Tree\Node;
    
    /**
     * @ORM\ManyToOne(targetEntity="Actividad")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $ParentNode;
    
    /**
     * Código correspondiente en el ClaNAE 1997 de INDEC.
     *
     * @var string 
     * @ORM\Column(type="string", nullable=true, length=50)
     */
    private $Clanae1997;
    
    /**
     * Código correspondiente en el ClaNAE 2010 de INDEC.
     *
     * @var string 
     * @ORM\Column(type="string", nullable=true, length=50)
     */
    private $Clanae2010;
    
    /**
     * Código correspondiente en la RG 3537/13 de AFIP.
     *
     * @var string 
     * @ORM\Column(type="string", nullable=true, length=50)
     *     
     * RG 3537/13 AFIP
     */
    private $ClaeAfip;
    
    /**
     * Código correspondiente en la Ley 854/11 de la DGR de TDF.
     *
     * @var string 
     * @ORM\Column(type="string", nullable=true, length=50)
     *     
     * Ley 854/11 DGR-TDF
     */
    private $DgrTdf;
    
    /**
     * Los códigos Clamae2014 tienen el siguiente formato: CDDGCSMM
     *     C Categoría, alfabética
     *     DD División, numérica
     *     G Grupo, numérico
     *     C Clase, numérica
     *     S Sub-clase, numérica
     *     MM Subdivisión del Municipio de Río Grande
     *
     * Por ejemplo: R9521000
     * 
     * @ORM\Column(type="string", nullable=true, length=50)
     */
    private $Clamae2014;
    
    /**
     * Indica la categoría correspondiente en los rubros anteriores.
     *
     * @var integer 
     * @ORM\Column(type="integer", nullable=false)
     */
    private $CategoriaAntigua = 0;
    
    /**
     * Código correspondiente en la tabla del CPU.
     *
     * @ORM\Column(type="string", nullable=true, length=50)
     */
    private $CodigoCpu;
    
    /**
     * Indica si esta actividad requiere de aprobación por parte de Bromatología e Higiene.
     *
     * @var bool 
     * @ORM\Column(type="boolean")
     */
    private $RequiereDbeh = false;
    
    /**
     * Indica si esta actividad requiere de aprobación por parte de Ecología y medioambiente.
     *
     * @var bool 
     * @ORM\Column(type="boolean")
     */
    private $RequiereDeyma = false;
    
    /**
     * Algunas actividades están exentas del requisito de habilitación comercial.
     *
     * @var bool 
     * @ORM\Column(type="boolean")
     */
    private $Exento = false;
    
    /**
     * Indica si esta actividad requiere la instalación de una cámara decantadora de barro.
     *
     * @var bool 
     * @ORM\Column(type="boolean")
     */
    private $RequiereCamaraBarro = false;
    
    /**
     * Indica si esta actividad requiere la instalación de una cámara decantadora de grasa.
     *
     * @var bool 
     * @ORM\Column(type="boolean")
     */
    private $RequiereCamaraGrasa = false;
    
    /**
     * Indica si esta actividad requiere la aprobación de Infraestructura Escolar de provincia.
     *
     * @var bool 
     * @ORM\Column(type="boolean")
     */
    private $RequiereInfEscolar = false;
    
    /**
     * Indica si esta actividad requiere un estudio de impacto sonoro.
     *
     * @var bool 
     * @ORM\Column(type="boolean")
     */
    private $RequiereImpactoSonoro = false;
    
    /**
     * Indica si esta actividad requiere especificar un factor de ocupación de personas, o cero si no requiere.
     *
     * @var bool 
     * @ORM\Column(type="integer")
     */
    private $RequiereFactorOcupacion = 0;
    
    /**
     * @var bool 
     * @ORM\Column(type="boolean")
     */
    private $Ley105 = false;
    
    /**
     * Texto que explica los alcances de la actividad.
     *
     * @var string 
     * @ORM\Column(type="text", nullable=true)
     */
    private $Incluye;
    
    /**
     * Texto que explica aquellas cosas que esta actividad no contempla.
     *
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
     * Indica si es una actividad (final = 1) o una categorización (final = 0).
     * Sólo pueden seleccionarse como actividades para un comercio las actividades finales.
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $Final = false;

    public static function NombresCategorias($categoria = null)
    {
        switch ($categoria) {
            case 'I':
                return 'Actividad primaria';
            case 'II':
                return 'Actividad secundaria: Industria';
            case 'III':
                return 'Actividad secundaria: Servicios';
            case 'IV':
                return 'Actividad terciaria: Venta';
            case 'V':
                return 'Actividad terciaria: Servicios';
            default:
                return $categoria;
        }
    }

    public function getCategoriaNombre()
    {
        return static::NombresCategorias($this->getCategoria());
    }

    public function getClamae2014Formateado()
    {
        $codigo = $this->getClamae2014();
        if (strlen($codigo) == 3) {
            return substr($codigo, 0, 2) . '-' . substr($codigo, 2, 1);
        } else 
            if (strlen($codigo) == 4) {
                return substr($codigo, 0, 2) . '-' . substr($codigo, 2, 2);
            } else 
                if (strlen($codigo) == 7) {
                    return substr($codigo, 0, 6) . '-' . substr($codigo, 6, 1);
                } else {
                    return $codigo;
                }
    }

    /*
     * Devuelve el "bread crumb" de la actividad actual
     */
    public function getRuta()
    {
        $res = '';
        $par = $this;
        while ($par = $par->getParentNode()) {
            if (strcmp($par->__toString(), $this->__toString()) !== 0) {
                if ($res) {
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

    public function getSangria($sangria = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;')
    {
        return str_repeat($sangria, $this->getNodeLevel());
    }

    public function getNombreConSangriaDeEspaciosDuros()
    {
        // Atención, los de la siguiente línea son 'espacios duros' (no se consolidan en el navegador)
        return $this->getSangria('   ') . $this->getNombre();
    }

    public function setClamae2014($Clamae2014)
    {
        $this->Clamae2014 = $Clamae2014;
        $this->Clanae2010 = substr($this->Clamae2014, 0, 6);
    }

    /**
     * @ignore
     */
    public function getClamae2014()
    {
        return $this->Clamae2014;
    }

    /**
     * @ignore
     */
    public function getClanae1997()
    {
        return $this->Clanae1997;
    }

    /**
     * @ignore
     */
    public function getClanae2010()
    {
        return $this->Clanae2010;
    }

    /**
     * @ignore
     */
    public function getClaeAfip()
    {
        return $this->ClaeAfip;
    }

    /**
     * @ignore
     */
    public function getDgrTdf()
    {
        return $this->DgrTdf;
    }

    /**
     * @ignore
     */
    public function getCodigoCpu()
    {
        return $this->CodigoCpu;
    }

    /**
     * @ignore
     */
    public function getRequiereDbeh()
    {
        return $this->RequiereDbeh;
    }

    /**
     * @ignore
     */
    public function getRequiereDeyma()
    {
        return $this->RequiereDeyma;
    }

    /**
     * @ignore
     */
    public function getExento()
    {
        return $this->Exento;
    }

    /**
     * @ignore
     */
    public function getLey105()
    {
        return $this->Ley105;
    }

    /**
     * @ignore
     */
    public function getIncluye()
    {
        return $this->Incluye;
    }

    /**
     * @ignore
     */
    public function getNoIncluye()
    {
        return $this->NoIncluye;
    }

    /**
     * @ignore
     */
    public function getInstructivos()
    {
        return $this->Instructivos;
    }

    /**
     * @ignore
     */
    public function setClanae1997($Clanae1997)
    {
        $this->Clanae1997 = $Clanae1997;
    }

    /**
     * @ignore
     */
    public function setClanae2010($Clanae2010)
    {
        $this->Clanae2010 = $Clanae2010;
    }

    /**
     * @ignore
     */
    public function setClaeAfip($ClaeAfip)
    {
        $this->ClaeAfip = $ClaeAfip;
    }

    /**
     * @ignore
     */
    public function setDgrTdf($DgrTdf)
    {
        $this->DgrTdf = $DgrTdf;
    }

    /**
     * @ignore
     */
    public function setCodigoCpu($CodigoCpu)
    {
        $this->CodigoCpu = $CodigoCpu;
    }

    /**
     * @ignore
     */
    public function setRequiereDbeh($RequiereDbeh)
    {
        $this->RequiereDbeh = $RequiereDbeh;
    }

    /**
     * @ignore
     */
    public function setRequiereDeyma($RequiereDeyma)
    {
        $this->RequiereDeyma = $RequiereDeyma;
    }

    /**
     * @ignore
     */
    public function setExento($Exento)
    {
        $this->Exento = $Exento;
    }

    /**
     * @ignore
     */
    public function setLey105($Ley105)
    {
        $this->Ley105 = $Ley105;
    }

    /**
     * @ignore
     */
    public function setIncluye($Incluye)
    {
        $this->Incluye = $Incluye;
    }

    /**
     * @ignore
     */
    public function setNoIncluye($NoIncluye)
    {
        $this->NoIncluye = $NoIncluye;
    }

    /**
     * @ignore
     */
    public function setInstructivos($Instructivos)
    {
        $this->Instructivos = $Instructivos;
    }

    /**
     * @ignore
     */
    public function getCategoriaAntigua()
    {
        return $this->CategoriaAntigua;
    }

    /**
     * @ignore
     */
    public function setCategoriaAntigua($CategoriaAntigua)
    {
        $this->CategoriaAntigua = $CategoriaAntigua;
    }

    /**
     * @ignore
     */
    public function getFinal()
    {
        return $this->Final;
    }

    /**
     * @ignore
     */
    public function setFinal($Final)
    {
        $this->Final = $Final;
    }

    /**
     * @ignore
     */
    public function getRequiereCamaraBarro()
    {
        return $this->RequiereCamaraBarro;
    }

    /**
     * @ignore
     */
    public function getRequiereCamaraGrasa()
    {
        return $this->RequiereCamaraGrasa;
    }

    /**
     * @ignore
     */
    public function setRequiereCamaraBarro($RequiereCamaraBarro)
    {
        $this->RequiereCamaraBarro = $RequiereCamaraBarro;
    }
    
    /**
     * @ignore
     */
    public function setRequiereCamaraGrasa($RequiereCamaraGrasa)
    {
        $this->RequiereCamaraGrasa = $RequiereCamaraGrasa;
    }

    /**
     * @ignore
     */
    public function getRequiereInfEscolar()
    {
        return $this->RequiereInfEscolar;
    }

    /**
     * @ignore
     */
    public function setRequiereInfEscolar($RequiereInfEscolar)
    {
        $this->RequiereInfEscolar = $RequiereInfEscolar;
    }

    /**
     * @ignore
     */
    public function getRequiereImpactoSonoro()
    {
        return $this->RequiereImpactoSonoro;
    }

    /**
     * @ignore
     */
    public function setRequiereImpactoSonoro($RequiereImpactoSonoro)
    {
        $this->RequiereImpactoSonoro = $RequiereImpactoSonoro;
        return $this;
    }

    /**
     * @ignore
     */
    public function getRequiereFactorOcupacion()
    {
        return $this->RequiereFactorOcupacion;
    }

    /**
     * @ignore
     */
    public function setRequiereFactorOcupacion($RequiereFactorOcupacion)
    {
        $this->RequiereFactorOcupacion = $RequiereFactorOcupacion;
        return $this;
    }
}
