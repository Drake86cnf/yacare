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
 *     "\Yacare\ObrasParticularesBundle\Entity\ActaObra" = "\Yacare\ObrasParticularesBundle\Entity\ActaObra",
 *     "\Yacare\ComercioBundle\Entity\ActaComercio" = "\Yacare\ComercioBundle\Entity\ActaComercio"
 * })
 */
abstract class Acta implements IActa
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Tapir\BaseBundle\Entity\ConNombre;
    use \Tapir\BaseBUndle\Entity\ConObs;
    use \Tapir\BaseBundle\Entity\Versionable;
    use \Yacare\BaseBundle\Entity\ConAdjuntos;
    
    public function __construct()
    {
        $this->Fecha = new \DateTime();
    }
    
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
     * @var string
     * 
     * @ORM\Column(type="text", nullable=true)
     */
    protected $Detalle;
    
    /**
     * Al cambiar el tipo o el número, genero el nombre.
     */
    public function setActaTipo($ActaTipo)
    {
        $this->ActaTipo = $ActaTipo;
        $this->GenerarNombre();
        return $this;
    }
    
    /**
     * Al cambiar el tipo o el número, genero el nombre.
     */
    public function setNumero($Numero)
    {
        $this->Numero = $Numero;
        $this->GenerarNombre();
        return $this;
    }
    
    protected function GenerarNombre() {
        $this->setNombre($this->getActaTipo() . ' Nº ' . $this->getNumero());
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
}
