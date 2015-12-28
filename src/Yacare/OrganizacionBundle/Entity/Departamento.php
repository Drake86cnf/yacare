<?php
namespace Yacare\OrganizacionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Yacare\BaseBundle\Model\Tree;

/**
 * Un departamento representa a cualquiera de las partes en las que se divide la administración pública como
 * ministerios, secretarías, subsecretarías, etc.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 *
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Table(name="Organizacion_Departamento", uniqueConstraints={
 *     @ORM\UniqueConstraint(name="ImportSrcId", columns={"ImportSrc", "ImportId"})
 *     })
 */
class Departamento implements Tree\NodeInterface
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Tapir\BaseBundle\Entity\ConNombre;
    use \Tapir\BaseBundle\Entity\Versionable;
    use \Tapir\BaseBundle\Entity\Suprimible;
    use \Tapir\BaseBundle\Entity\Importable;
    use \Yacare\BaseBundle\Model\Tree\Node;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    
    /**
     * El rango del departamento.
     *
     * Los rangos numéricamente más bajos son departamentos de nivel superior.
     * 
     * @var integer
     *
     * @see RangosNombres() RangosNombres()
     * 
     * @ORM\Column(type="integer", nullable=true)
     */
    private $Rango;
    
    /**
     * El código de este departamento (opcional).
     * 
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $Codigo;
    
    /**
     * El nombre original del departamento en el sistema de Gestión.
     *
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $NombreOriginal;
    
    /**
     * Indica si hace parte diario.
     * 
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     */
    private $HaceParteDiario = false;
    
    /**
     * Código que identifica al departamento en el Payroll.
     * 
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    private $CodigoPayroll = 0;
    
    /**
     * El nodo de nivel superior.
     * 
     * @var Departamento
     *
     * @see \Yacare\BaseBundle\Model\Tree\Node Node
     * 
     * @ORM\ManyToOne(targetEntity="Departamento", cascade={ "all" })
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $ParentNode;
    
    /**
     * Devuelve nombres de rango normalizados.
     *
     * @param  integer $estado
     * @return string
     */
    public static function NombreRango($rango)
    {
        if(array_key_exists($rango, Departamento::NombresRangos())) {
            return Departamento::NombresRangos()[$rango];
        } else {
            return $rango;
        }
    }
    
    /**
     * Devuelve un array con los posibles rangos y sus nombres.
     */
    public static function NombresRangos() {
        return array(
            1 => 'Ejecutivo',
            20 => 'Ministerio',
            30 => 'Secretaría',
            40 => 'Subsecretaría',
            50 => 'Dirección',
            60 => 'Subdirección',
            70 => 'Sector'
        );
    }
    
    /**
     * Devuelve el nombre del rango.
     * 
     * @return string
     */
    public function getRangoNombre()
    {
        return $this->NombreRango($this->getRango());
    }

    /**
     * @param string $sangria
     */
    public function getSangria($sangria = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;')
    {
        return str_repeat($sangria, $this->getNodeLevel());
    }

    /**
     * @return string
     */
    public function getSangriaDeEspaciosDuros()
    {
        // Atención, son 'espacios duros'
        return $this->getSangria('        ');
    }

    /**
     * @return string
     */
    public function getNombreConSangriaDeEspaciosDuros()
    {
        // Atención, son 'espacios duros'
        return $this->getSangria('        ') . $this->getNombre();
    }

    /**
     * @ignore
     */
    public function getRango()
    {
        return $this->Rango;
    }

    /**
     * @ignore
     */
    public function setRango($Rango)
    {
        $this->Rango = $Rango;
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
    public function getHaceParteDiario()
    {
        return $this->HaceParteDiario;
    }

    /**
     * @ignore
     */
    public function setHaceParteDiario($HaceParteDiario)
    {
        $this->HaceParteDiario = $HaceParteDiario;
        return $this;
    }

    /**
     * @ignore
     */
    public function getNombreOriginal()
    {
        return $this->NombreOriginal;
    }

    /**
     * @ignore
     */
    public function setNombreOriginal($NombreOriginal)
    {
        $this->NombreOriginal = $NombreOriginal;
        return $this;
    }

    /**
     * @ignore
     */
    public function getCodigoPayroll()
    {
        return $this->CodigoPayroll;
    }

    /**
     * @ignore
     */
    public function setCodigoPayroll($CodigoPayroll)
    {
        $this->CodigoPayroll = $CodigoPayroll;
        return $this;
    }
}
