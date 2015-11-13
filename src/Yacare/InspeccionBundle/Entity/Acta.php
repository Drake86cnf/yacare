<?php
namespace Yacare\InspeccionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Acta.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 * 
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Table(name="Inspeccion_Acta")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="ActaTipo", type="string")
 * @ORM\DiscriminatorMap({
 *     "\Yacare\InspeccionBundle\Entity\Acta" = "\Yacare\InspeccionBundle\Entity\Acta",
 *     "\Yacare\ObrasParticularesBundle\Entity\Acta" = "\Yacare\ObrasParticularesBundle\Entity\Acta"
 * })
 */
abstract class Acta
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Tapir\BaseBundle\Entity\ConNombre;
    use \Tapir\BaseBundle\Entity\Versionable;
    use \Yacare\BaseBundle\Entity\ConAdjuntos;
    
    /**
     * El tipo de acta.
     * 
     * @var integer
     * 
     * @ORM\Column(type="integer")
     */
    private $Tipo;
    
    /*
     * Un talonario.
     * 
     * @var ActaTalonario
     * 
     * @ORM\ManyToOne(targetEntity="Yacare\InspeccionBundle\Entity\ActaTalonario")
     * @ORM\JoinColumn(nullable=false)
     
    protected $Talonario;*/
    
    /**
     * @var string
     * 
     * @ORM\Column(type="string", nullable=true)
     */
    private $SubTipo;
    
    /**
     * @var int
     * 
     * @ORM\Column(type="integer")
     */
    private $Numero;
    
    /**
     * @var \DateTime
     * 
     * @ORM\Column(type="datetime")
     */
    private $Fecha;
    
    /**
     * @var \Yacare\BaseBundle\Entity\Persona
     * 
     * @ORM\ManyToOne(targetEntity="Yacare\BaseBundle\Entity\Persona")
     */
    protected $FuncionarioPrincipal;
    
    /**
     * @var \Yacare\BaseBundle\Entity\Persona
     * 
     * @ORM\ManyToOne(targetEntity="Yacare\BaseBundle\Entity\Persona")
     */
    protected $FuncionarioSecundario;
    
    /**
     * @var string
     * 
     * @ORM\Column(type="string")
     */
    private $ResponsableNombre;
    
    /**
     * @var string
     * 
     * @ORM\Column(type="text", nullable=true)
     */
    protected $Detalle;
    
    /**
     * @var string
     * 
     * @ORM\Column(type="text", nullable=true)
     */
    protected $Obs;

    /**
     * Devuelve el nombre normalizado del tipo de acta.
     */
    public function getActaTipoNombre()
    {
        return self::ActaTipoNombres($this->getTipo());
    }
    
    /**
     * Normaliza el nombre del tipo de acta.
     * 
     * @param  integer $rango
     * @return string
     */
    public static function ActaTipoNombres($rango)
    {
        switch($rango) {
            case 0:
                return 'Notificación';
            case 1:
                return 'Infracción';
            case 2:
                return 'Compromiso';
            case 3:
                return 'Constatación';
            case 4:
                return 'Inspección';
            case 5:
                return 'Infracción/Suspesión';
            default:
                return '';
        }
    }
    
    /**
     * Genera el nombre a mostrar.
     * 
     * @return string
     */
    public function ConstruirNombre()
    {
        $res = 'Acta ' . $this->getSubTipo() . ' Nº ' . $this->getNumero();
        return $res;
    }

    /**
     * @ignore
     */
    public function getTipo()
    {
        return $this->Tipo;
    }
    
    /**
     * @ignore
     */
    public function setTipo($tipo)
    {
        $this->Tipo = $tipo;
    }
    
    /**
     * @ignore
     */
    public function getTalonario()
    {
        return $this->Talonario;
    }

    /**
     * @ignore
     */
    public function setTalonario($Talonario)
    {
        $this->Talonario = $Talonario;
        $this->setNombre($this->ConstruirNombre());
    }

    /**
     * @ignore
     */
    public function getSubTipo()
    {
        return $this->SubTipo;
    }

    /**
     * @ignore
     */
    public function setSubTipo($SubTipo)
    {
        $this->SubTipo = $SubTipo;
        $this->setNombre($this->ConstruirNombre());
    }

    /**
     * @ignore
     */
    public function getNumero()
    {
        return $this->Numero;
    }

    /**
     * @ignore
     */
    public function setNumero($Numero)
    {
        $this->Numero = $Numero;
        $this->setNombre($this->ConstruirNombre());
    }

    /**
     * @ignore
     */
    public function getFecha()
    {
        return $this->Fecha;
    }

    /**
     * @ignore
     */
    public function setFecha(\DateTime $Fecha)
    {
        $this->Fecha = $Fecha;
    }

    /**
     * @ignore
     */
    public function getFuncionarioPrincipal()
    {
        return $this->FuncionarioPrincipal;
    }

    /**
     * @ignore
     */
    public function setFuncionarioPrincipal($FuncionarioPrincipal)
    {
        $this->FuncionarioPrincipal = $FuncionarioPrincipal;
    }

    /**
     * @ignore
     */
    public function getFuncionarioSecundario()
    {
        return $this->FuncionarioSecundario;
    }

    /**
     * @ignore
     */
    public function setFuncionarioSecundario($FuncionarioSecundario)
    {
        $this->FuncionarioSecundario = $FuncionarioSecundario;
    }

    /**
     * @ignore
     */
    public function getResponsableNombre()
    {
        return $this->ResponsableNombre;
    }

    /**
     * @ignore
     */
    public function setResponsableNombre($ResponsableNombre)
    {
        $this->ResponsableNombre = $ResponsableNombre;
    }

    /**
     * @ignore
     */
    public function getDetalle()
    {
        return $this->Detalle;
    }

    /**
     * @ignore
     */
    public function setDetalle($Detalle)
    {
        $this->Detalle = $Detalle;
    }

    /**
     * @ignore
     */
    public function getObs()
    {
        return $this->Obs;
    }

    /**
     * @ignore
     */
    public function setObs($Obs)
    {
        $this->Obs = $Obs;
    }
}
