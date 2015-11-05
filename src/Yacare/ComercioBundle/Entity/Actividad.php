<?php
namespace Yacare\ComercioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Yacare\BaseBundle\Model\Tree;

/**
 * Representa una actividad económica, según ClaMAE 2014.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
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
     * Actividad que contiene a la actual.
     * 
     * @var Actividad
     * 
     * @ORM\ManyToOne(targetEntity="Actividad", cascade={"persist"})
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $ParentNode;
    
    /**
     * Código correspondiente en el ClaNAE 1997 de INDEC.
     *
     * @var string
     * 
     * @ORM\Column(type="string", nullable=true, length=50)
     */
    private $Clanae1997;
    
    /**
     * Código correspondiente en el ClaNAE 2010 de INDEC.
     *
     * @var string
     * 
     * @ORM\Column(type="string", nullable=true, length=50)
     */
    private $Clanae2010;
    
    /**
     * Código correspondiente en la RG 3537/13 de AFIP.
     *
     * RG 3537/13 AFIP
     * 
     * @var string
     * 
     * @ORM\Column(type="string", nullable=true, length=50)
     */
    private $ClaeAfip;
    
    /**
     * Código correspondiente en la Ley 854/11 de la DGR de TDF.
     * 
     * Ley 854/11 DGR-TDF
     *
     * @var string
     * 
     * @ORM\Column(type="string", nullable=true, length=50)
     */
    private $DgrTdf;
    
    /**
     * Los códigos Clamae2014 tienen el siguiente formato: CDDGCSMM
     * * C Categoría, alfabética
     * * DD División, numérica
     * * G Grupo, numérico
     * * C Clase, numérica
     * * S Sub-clase, numérica
     * * MM Subdivisión del Municipio de Río Grande
     *
     * Por ejemplo: R9521000
     * 
     * @var string
     * 
     * @ORM\Column(type="string", nullable=true, length=50)
     */
    private $Clamae2014;
    
    /**
     * Indica la categoría correspondiente en los rubros anteriores.
     *
     * @var integer
     * 
     * @ORM\Column(type="integer", nullable=false)
     */
    private $CategoriaAntigua = 0;
    
    /**
     * Código correspondiente en la tabla del CPU.
     * 
     * @var string
     *
     * @ORM\Column(type="string", nullable=true, length=50)
     */
    private $CodigoCpu;
    
    /**
     * Las etiquetas asociadas a esta actividad..
     * 
     * @var ActividadEtiqueta
     *
     * @ORM\ManyToMany(targetEntity="Yacare\ComercioBundle\Entity\ActividadEtiqueta", inversedBy="Actividades")
     * @ORM\JoinTable(name="Comercio_Actividad_ActividadEtiqueta",
     *     joinColumns={@ORM\JoinColumn(name="Actividad_id", referencedColumnName="id", nullable=true)})
     */
    protected $Etiquetas;
    
    /**
     * El nivel de riesgo que posee cada actividad comercial.
     *
     * @var NivelRiesgo
     * 
     * @ORM\Column(type="integer", nullable=false)
     */
    private $NivelRiesgo = 1;

    /*
     * Devuelve true si la actividad contiene una etiqueta (buśqueda por código).
     */
    public function ContieneEtiquetaPorCodigo($codigo)
    {
        foreach ($this->Etiquetas as $Etiqueta) {
            if ($Etiqueta->getCodigo() == $codigo) {
                return true;
            }
        }
        return false;
    }

    public function _construct()
    {
        $this->Etiquetas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->Requisitos = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Texto que explica los alcances de la actividad.
     *
     * @var string
     * 
     * @ORM\Column(type="text", nullable=true)
     */
    private $Incluye;
    
    /**
     * Texto que explica aquellas cosas que esta actividad no contempla.
     *
     * @var string
     * 
     * @ORM\Column(type="text", nullable=true)
     */
    private $NoIncluye;
    
    /**
     * @var string
     * 
     * @ORM\Column(type="string", nullable=true, length=255)
     */
    private $Instructivos;
    
    /**
     * Indica si es una actividad (final = 1) o una categorización (final = 0).
     * Sólo pueden seleccionarse como actividades para un comercio las actividades finales.
     * 
     * @var boolean
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $Final = false;

    /**
     * Devuelve el nombre correspondiente de la categoría.
     * 
     * @param  string $categoria|null
     * @return string|null
     */
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

    /**
     * Obtiene el nombre correspondiente de la categoría.
     * 
     * @return string
     */
    public function getCategoriaNombre()
    {
        return static::NombresCategorias($this->getCategoria());
    }

    /**
     * Devuelve nomenclador de actividades comerciales, formateado.
     * 
     * @return string
     */
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

    /**
     * Devuelve el "bread crumb" de la actividad actual.
     * 
     * @return string
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

    /**
     * Devuelve 'Clamae2014'.
     * 
     * @return string
     */
    public static function getMaterializedPathMaterial()
    {
        return 'Clamae2014';
    }

    public function getSangria($sangria = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;')
    {
        return str_repeat($sangria, $this->getNodeLevel());
    }

    /**
     * @return string
     */
    public function getNombreConSangriaDeEspaciosDuros()
    {
        // Atención, los de la siguiente línea son 'espacios duros' (no se consolidan en el navegador)
        return $this->getSangria('   ') . $this->getNombre();
    }

    /**
     * Establece el nomenclador de activiadades comerciales, a las propiedades correpsondientes.
     * 
     * @param string $Clamae2014
     */
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
    public function getEtiquetas()
    {
        return $this->Etiquetas;
    }

    /**
     * @ignore
     */
    public function setEtiquetas($Etiquetas)
    {
        $this->Etiquetas = $Etiquetas;
        return $this;
    }

    /**
     * @ignore
     */
    public function getNivelRiesgo()
    {
        return $this->NivelRiesgo;
    }

    /**
     * @ignore
     */
    public function setNivelRiesgo($NivelRiesgo)
    {
        $this->NivelRiesgo = $NivelRiesgo;
        return $this;
    }
 
}
