<?php
namespace Yacare\CatastroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Representa una partida inmobiliaria.
 *
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Table(name="Catastro_Partida", uniqueConstraints={
 *         @ORM\UniqueConstraint(name="SeccionMacizoParcelaSubparcelaUf",
 *          columns={"Seccion", "MacizoNum", "MacizoAlfa", "ParcelaNum", "ParcelaAlfa",
 *              "SubparcelaNum", "SubparcelaAlfa", "UnidadFuncional"})
 *         }, 
 *     indexes={
 *         @ORM\Index(name="Catastro_Partida_SeccionMacizoParcelaSubparcelaUf", 
 *             columns={"Seccion", "MacizoAlfa", "MacizoNum", "ParcelaAlfa", "ParcelaNum", "UnidadFuncional"}),
 *         @ORM\Index(name="Catastro_Partida_Legajo", columns={"Legajo"}),
 *         @ORM\Index(name="Catastro_Partida_Numero", columns={"Numero"})
 *         }
 * )
 */
class Partida
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Tapir\BaseBundle\Entity\ConNombre;
    use \Yacare\BaseBundle\Entity\ConDomicilioLocal;
    use \Tapir\BaseBundle\Entity\Versionable;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    
    public function __construct()
    {
        $this->Personas = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * La sección.
     *
     * @var string
     * 
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $Seccion;
    
    /**
     * El macizo alfa.
     * 
     * @var string
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $MacizoAlfa;
    
    /**
     * El número de macizo.
     * 
     * @var string
     * 
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $MacizoNum;
    
    
    /**
     * La parcela alfa.
     *
     * @var string
     * 
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $ParcelaAlfa;
    
    /**
     * El número de parcela.
     *
     * @var string
     * 
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $ParcelaNum;
    
    /**
     * La Subparcela alfa.
     *
     * @var string
     *
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $SubparcelaAlfa;
    
    /**
     * El número de Subparcela.
     *
     * @var string
     *
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $SubparcelaNum;
    
    /**
     * @var int 
     * 
     * @ORM\Column(type="integer")
     */
    private $UnidadFuncional;
    
    /**
     * El titular.
     * 
     * @var \Yacare\BaseBundle\Entity\Persona
     * 
     * @ORM\ManyToOne(targetEntity="\Yacare\BaseBundle\Entity\Persona")
     * @ORM\JoinColumn(nullable=true)
     */
    private $Titular;
    
    /**
     * Las personas que están relacionadas con esta partida.
     *
     * @var Yacare\BaseBundle\Entity\Persona
     *
     * @ORM\ManyToMany(targetEntity="Yacare\BaseBundle\Entity\Persona")
     * @ORM\JoinTable(name="Catastro_PartidaPersona",
     *  joinColumns={ @ORM\JoinColumn(name="Partida_id", referencedColumnName="id") },
     *  inverseJoinColumns={ @ORM\JoinColumn(name="Persona_id", referencedColumnName="id") }
     * )
     */
    protected $Personas;
    
    /**
     * La zona.
     * 
     * @var Zona
     * 
     * @ORM\ManyToOne(targetEntity="\Yacare\CatastroBundle\Entity\Zona")
     * @ORM\JoinColumn(nullable=true)
     */
    private $Zona;
    
    /**
     * El número de partida.
     * 
     * @var integer
     * 
     * @ORM\Column(type="integer")
     */
    private $Numero;
    
    /**
     * El número de legajo.
     * 
     * @var integer
     * 
     * @ORM\Column(type="integer", nullable=true)
     */
    private $Legajo;
    
    /**
     * Devuelve el combinado de MacizoAlfa y MacizoNum.
     */
    public function getMacizo()
    {
        return $this->getMacizoAlfa() . $this->getMacizoNum();
    }
    
    /**
     * Devuelve el combinado de ParcelaAlfa y ParcelaNum.
     */
    public function getParcela()
    {
        return $this->getParcelaAlfa() . $this->getParcelaNum();
    }
    
    /**
     * Devuelve el combinado de SubparcelaAlfa y SubparcelaNum.
     */
    public function getSubparcela()
    {
        return $this->getSubparcelaAlfa() . $this->getSubparcelaNum();
    }

    /**
     * Devuevle una descripción textual de sección, macizo, parcela, subparcela, unidad funcional.
     * @return string
     */
    public function getSmpu()
    {
        $res = 'Sección ' . $this->getSeccion() . ', macizo ' . $this->getMacizo() . ', parcela ' . $this->getParcela();
        if ($this->getSubparcela()) {
            $res .= ', subparcela ' . $this->getSubparcela();
        }
        if ($this->UnidadFuncional > 0) {
            $res .= ', UF ' . $this->UnidadFuncional;
        }
        return $res;
    }

    /**
     * Establece inteligentemente el nombre completo de la partida.
     */
    public function CalcularNombre()
    {
        if ($this->getDomicilioCalle() && $this->getDomicilioCalle()->getId()) {
            $this->Nombre = $this->getDomicilioCalle()->getNombre();
            
            if ($this->DomicilioNumero) {
                $this->Nombre .= ' Nº ' . $this->DomicilioNumero;
            }
            if ($this->DomicilioPiso) {
                $this->Nombre .= ', piso ' . $this->DomicilioPiso;
            }
            if ($this->DomicilioPuerta) {
                $this->Nombre .= ', pta. ' . $this->DomicilioPuerta;
            }
            
            $this->Nombre .= " (sección " . $this->getSeccion() . ", macizo " . $this->getMacizo() . ", parcela " . $this->getParcela();
            if ($this->getSubparcela()) {
                $this->Nombre .= ', subparcela ' . $this->getSubparcela();
            }
            if ($this->UnidadFuncional > 0) {
                $this->Nombre .= ', UF ' . $this->UnidadFuncional;
            }
            $this->Nombre .= ")";
        } else {
            $this->Nombre = "Sección " . $this->getSeccion() . ", macizo " . $this->getMacizo() . ", parcela " . $this->getParcela();
            if ($this->getSubparcela()) {
                $this->Nombre .= ', subparcela ' . $this->getSubparcela();
            }
            if ($this->UnidadFuncional > 0) {
                $this->Nombre .= ', UF ' . $this->UnidadFuncional;
            }
        }
    }

    /**
     * @ignore
     */
    public function getNombre()
    {
        $this->CalcularNombre();
        return $this->Nombre;
    }

    /**
     * @ignore
     */
    public function setNombre($Nombre)
    {
        $this->CalcularNombre();
    }

    /**
     * @ignore
     */
    public function getSeccion()
    {
        return $this->Seccion;
    }

    /**
     * @ignore
     */
    public function setSeccion($Seccion)
    {
        $this->Seccion = $Seccion;
        $this->CalcularNombre();
    }

    /**
     * @ignore
     */
    public function getMacizoAlfa()
    {
        return $this->MacizoAlfa;
    }

    /**
     * @ignore
     */
    public function setMacizoAlfa($MacizoAlfa)
    {
        $this->MacizoAlfa = $MacizoAlfa;
        $this->CalcularNombre();
    }

    /**
     * @ignore
     */
    public function getMacizoNum()
    {
        return $this->MacizoNum;
    }

    /**
     * @ignore
     */
    public function setMacizoNum($MacizoNum)
    {
        $this->MacizoNum = $MacizoNum;
        $this->CalcularNombre();
    }

    /**
     * @ignore
     */
    public function getParcelaAlfa()
    {
        return $this->ParcelaAlfa;
    }

    /**
     * @ignore
     */
    public function setParcelaAlfa($ParcelaAlfa)
    {
        $this->ParcelaAlfa = $ParcelaAlfa;
        $this->CalcularNombre();
    }

    /**
     * @ignore
     */
    public function getParcelaNum()
    {
        return $this->ParcelaNum;
    }

    /**
     * @ignore
     */
    public function setParcelaNum($ParcelaNum)
    {
        $this->ParcelaNum = $ParcelaNum;
        $this->CalcularNombre();
    }


    /**
     * @ignore
     */
    public function getUnidadFuncional()
    {
        return $this->UnidadFuncional;
    }

    /**
     * @ignore
     */
    public function getLegajo()
    {
        return $this->Legajo;
    }

    /**
     * @ignore
     */
    public function setUnidadFuncional($UnidadFuncional)
    {
        $this->UnidadFuncional = $UnidadFuncional;
        $this->CalcularNombre();
    }

    /**
     * @ignore
     */
    public function setLegajo($Legajo)
    {
        $this->Legajo = $Legajo;
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
        $this->CalcularNombre();
    }

    /**
     * @ignore
     */
    public function getZona()
    {
        return $this->Zona;
    }

    /**
     * @ignore
     */
    public function setZona($Zona)
    {
        $this->Zona = $Zona;
    }

    /**
     * @ignore
     */
    public function getTitular()
    {
        return $this->Titular;
    }

    /**
     * @ignore
     */
    public function setTitular($Titular)
    {
        $this->Titular = $Titular;
    }

    /**
     * @return the Reponsable
     */
    public function getResponsables()
    {
        return $this->Responsables;
    }

    /**
     * @param  $Responsables
     */
    public function setResponsables($Responsables)
    {
        $this->Responsables = $Responsables;
        return $this;
    }

    /**
     * @return the string
     */
    public function getSubparcelaAlfa()
    {
        return $this->SubparcelaAlfa;
    }

    /**
     * @param string $SubparcelaAlfa
     */
    public function setSubparcelaAlfa($SubparcelaAlfa)
    {
        $this->SubparcelaAlfa = $SubparcelaAlfa;
        $this->CalcularNombre();
        return $this;
    }

    /**
     * @return the string
     */
    public function getSubparcelaNum()
    {
        return $this->SubparcelaNum;
    }

    /**
     * @param string $SubparcelaNum
     */
    public function setSubparcelaNum($SubparcelaNum)
    {
        $this->SubparcelaNum = $SubparcelaNum;
        $this->CalcularNombre();
        return $this;
    }

    /**
     * @return the Persona
     */
    public function getPersonas()
    {
        return $this->Personas;
    }

    /**
     * @param Yacare\BaseBundle\Entity\Persona $Personas
     */
    public function setPersonas($Personas)
    {
        $this->Personas = $Personas;
        return $this;
    }
 
 
}
