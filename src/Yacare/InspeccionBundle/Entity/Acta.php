<?php
namespace Yacare\InspeccionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Acta.
 *
 * @author Ernesto Carrea <equistango@gmail.com>
 *        
 *         @ORM\Table(name="Inspeccion_Acta")
 *         @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 *         @ORM\InheritanceType("JOINED")
 *         @ORM\DiscriminatorColumn(name="ActaTipo", type="string")
 *         @ORM\DiscriminatorMap({
 *         "\Yacare\InspeccionBundle\Entity\Acta" = "\Yacare\InspeccionBundle\Entity\Acta",
 *         "\Yacare\ObrasParticularesBundle\Entity\Acta" = "\Yacare\ObrasParticularesBundle\Entity\Acta"
 *         })
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
     *
     * @var string @ORM\Column(type="string")
     */
    private $SubTipo;

    /**
     *
     * @var int @ORM\Column(type="integer")
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
     *
     * @var string @ORM\Column(type="string")
     */
    private $ResponsableNombre;

    /**
     *
     * @var string @ORM\Column(type="text", nullable=true)
     */
    protected $Detalle;

    /**
     *
     * @var string @ORM\Column(type="text", nullable=true)
     */
    protected $Obs;

    public function ConstruirNombre()
    {
        $res = 'Acta ' . $this->getSubTipo() . ' Nº ' . $this->getNumero();
        return $res;
    }

    public function getTalonario()
    {
        return $this->Talonario;
    }

    public function setTalonario($Talonario)
    {
        $this->Talonario = $Talonario;
        $this->setNombre($this->ConstruirNombre());
    }

    public function getSubTipo()
    {
        return $this->SubTipo;
    }

    public function setSubTipo($SubTipo)
    {
        $this->SubTipo = $SubTipo;
        $this->setNombre($this->ConstruirNombre());
    }

    public function getNumero()
    {
        return $this->Numero;
    }

    public function setNumero($Numero)
    {
        $this->Numero = $Numero;
        $this->setNombre($this->ConstruirNombre());
    }

    public function getFecha()
    {
        return $this->Fecha;
    }

    public function setFecha(\DateTime $Fecha)
    {
        $this->Fecha = $Fecha;
    }

    public function getFuncionarioPrincipal()
    {
        return $this->FuncionarioPrincipal;
    }

    public function setFuncionarioPrincipal($FuncionarioPrincipal)
    {
        $this->FuncionarioPrincipal = $FuncionarioPrincipal;
    }

    public function getFuncionarioSecundario()
    {
        return $this->FuncionarioSecundario;
    }

    public function setFuncionarioSecundario($FuncionarioSecundario)
    {
        $this->FuncionarioSecundario = $FuncionarioSecundario;
    }

    public function getResponsableNombre()
    {
        return $this->ResponsableNombre;
    }

    public function setResponsableNombre($ResponsableNombre)
    {
        $this->ResponsableNombre = $ResponsableNombre;
    }

    public function getDetalle()
    {
        return $this->Detalle;
    }

    public function setDetalle($Detalle)
    {
        $this->Detalle = $Detalle;
    }

    public function getObs()
    {
        return $this->Obs;
    }

    public function setObs($Obs)
    {
        $this->Obs = $Obs;
    }
}
