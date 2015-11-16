<?php
namespace Yacare\InspeccionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;

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
    use \Tapir\BaseBUndle\Entity\ConObs;
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
     * Tipo de acta (Infracción, Constatación, etc) para cualquiera de la áreas.
     * 
     * @var string
     * 
     * @ORM\Column(type="string", nullable=false)
     */
    private $SubTipo;
    
    /**
     * El número de acta manuscrita.
     * 
     * @var int
     * 
     * @ORM\Column(type="integer")
     */
    private $Numero;
    
    /**
     * La fecha de redactada el acta.
     * 
     * @var \DateTime
     * 
     * @ORM\Column(type="datetime")
     */
    private $Fecha;
    
    /**
     * El agente inspector que redacta el acta.
     * 
     * @var \Yacare\BaseBundle\Entity\Persona
     * 
     * @ORM\ManyToOne(targetEntity="Yacare\BaseBundle\Entity\Persona")
     * @JoinColumn(nullable=false)
     */
    protected $FuncionarioPrincipal;
    
    /**
     * El agente inspector adjunto (opcional)
     * 
     * @var \Yacare\BaseBundle\Entity\Persona
     * 
     * @ORM\ManyToOne(targetEntity="Yacare\BaseBundle\Entity\Persona")
     */
    protected $FuncionarioSecundario;
    
    /**
     * Responsable a quién se le hace la notificación en caso de ausencia del propietario de la partida.
     * 
     * @var string
     * 
     * @ORM\Column(type="string", nullable=true)
     */
    private $ResponsableNombre;
    
    /**
     * @var string
     * 
     * @ORM\Column(type="text", nullable=true)
     */
    protected $Detalle;
    
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
