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
     * @ORM\ManyToOne(targetEntity="Departamento")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $ParentNode;

    /**
     * Normaliza los nombres de rangos de departamentos.
     * 
     * @param integer $rango
     * @return string
     */
    public static function RangosNombres($rango)
    {
        switch ($rango) {
            case 1:
                return 'Ejecutivo';
            case 20:
                return 'Ministerio';
            case 30:
                return 'Secretaría';
            case 40:
                return 'Subsecretaría';
            case 50:
                return 'Dirección';
            case 60:
                return 'Subdirección';
            case 70:
                return 'Sector';
            default:
                return '';
        }
    }

    /**
     * Devuelve el nombre del rango.
     * 
     * @return string
     */
    public function getRangoNombre()
    {
        return Departamento::RangosNombres($this->getRango());
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
        // Atención, son 'espacios duro'
        return $this->getSangria('        ');
    }

    /**
     * @return string
     */
    public function getNombreConSangriaDeEspaciosDuros()
    {
        // Atención, son 'espacios duro'
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
}
