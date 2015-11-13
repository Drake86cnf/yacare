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
 * @ORM\DiscriminatorColumn(name="ActaTipoClase", type="string")
 * @ORM\DiscriminatorMap({
 *     "\Yacare\ObrasParticularesBundle\Entity\ActaObra" = "\Yacare\ObrasParticularesBundle\Entity\ActaObra"
 * })
 */
abstract class Acta implements IActa
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Tapir\BaseBundle\Entity\ConNombre;
    use \Tapir\BaseBundle\Entity\Versionable;
    use \Yacare\BaseBundle\Entity\ConAdjuntos;
    
    /**
     * El tipo de acta.
     * 
     * @ORM\ManyToOne(targetEntity="Yacare\InspeccionBundle\Entity\ActaTipo")
     * @ORM\JoinColumn(nullable=false)
     */
    private $ActaTipo;
    
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
     * @ORM\Column(type="string", nullable=false)
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
     * Genera el nombre a mostrar.
     * 
     * @return string
     */
    public function ConstruirNombre()
    {
        $res = $this->getTipo()->getNombre() . ' Nº ' . $this->getNumero();
        return $res;
    }

    /**
     * @ignore
     */
    public function getActaTipo()
    {
        return $this->ActaTipo;
    }

    /**
     * @ignore
     */
    public function setActaTipo($ActaTipo)
    {
        $this->ActaTipo = $ActaTipo;
        return $this;
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
        return $this;
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
        return $this;
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
    public function setFecha($Fecha)
    {
        $this->Fecha = $Fecha;
        return $this;
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
        return $this;
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
        return $this;
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
        return $this;
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
        return $this;
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
        return $this;
    }
}
