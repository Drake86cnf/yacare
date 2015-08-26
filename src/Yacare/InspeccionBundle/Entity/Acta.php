<?php
namespace Yacare\InspeccionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Acta.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 *        
 * @ORM\Table(name="Inspeccion_Acta")
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="ActaTipo", type="string")
 * @ORM\DiscriminatorMap({
 *     "\Yacare\InspeccionBundle\Entity\Acta" = "\Yacare\InspeccionBundle\Entity\Acta",
 *     "\Yacare\ObrasParticularesBundle\Entity\Acta" = "\Yacare\ObrasParticularesBundle\Entity\Acta"
 * })
 */
class Acta
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Tapir\BaseBundle\Entity\ConNombre;
    use \Tapir\BaseBundle\Entity\Versionable;
    use \Yacare\BaseBundle\Entity\ConAdjuntos;
    
    /**
     * @ORM\ManyToOne(targetEntity="Yacare\InspeccionBundle\Entity\ActaTalonario")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $Talonario;
    
    /**
     * @var string
     * 
     * @ORM\Column(type="string")
     */
    private $SubTipo;
    
    /**
     * @var int
     * 
     * @ORM\Column(type="integer")
     */
    private $Numero;
    
    /**
     * @ORM\Column(type="datetime")
     */
    private $Fecha;
    
    /**
     * @ORM\ManyToOne(targetEntity="Yacare\BaseBundle\Entity\Persona")
     */
    protected $FuncionarioPrincipal;
    
    /**
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

    public function ConstruirNombre()
    {
        $res = 'Acta ' . $this->getSubTipo() . ' Nº ' . $this->getNumero();
        return $res;
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
