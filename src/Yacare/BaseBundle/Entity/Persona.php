<?php

namespace Yacare\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\BaseBundle\Entity\Persona
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Persona
{
    use \Yacare\BaseBundle\Entity\Timestampable;
    
    /**
     * @ORM\ManyToMany(targetEntity="PersonaGrupo", inversedBy="Personas")
     */
    public $Grupos;
    
    
    public function __construct()
    {
        $this->Grupos = new \Doctrine\Common\Collections\ArrayCollection();
    }  
    
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * @ORM\OneToMany(targetEntity="\Yacare\RecursosHumanosBundle\Entity\Agente", mappedBy="Persona")
     */
    private $Agente;
    
    /**
     * @var string $Apellido
     *
     * @ORM\Column(name="Apellido", type="string", length=255)
     */
    private $Apellido;

    /**
     * @var string $Nombre
     *
     * @ORM\Column(name="Nombre", type="string", length=255)
     */
    private $Nombre;

    /**
     * @var string $RazonSocial
     *
     * @ORM\Column(name="RazonSocial", type="string", length=255, nullable=true)
     */
    private $RazonSocial = null;

    /**
     * @var integer $TipoDocumento
     *
     * @ORM\Column(name="TipoDocumento", type="integer")
     */
    private $TipoDocumento;

    /**
     * @var integer $NumeroDocumento
     *
     * @ORM\Column(name="NumeroDocumento", type="integer")
     */
    private $NumeroDocumento;

    /**
     * @var string $Calle
     *
     * @ORM\Column(name="Calle", type="string", length=255)
     */
    private $Calle;

    /**
     * @var integer $NumeroCalle
     *
     * @ORM\Column(name="NumeroCalle", type="integer")
     */
    private $NumeroCalle;

    /**
     * @var integer $Piso
     *
     * @ORM\Column(name="Piso", type="integer", nullable=true)
     */
    private $Piso;

    /**
     * @var integer $Puerta
     *
     * @ORM\Column(name="Puerta", type="integer", nullable=true)
     */
    private $Puerta;

    /**
     * @var integer $NumeroTelefono
     *
     * @ORM\Column(name="NumeroTelefono", type="integer")
     */
    private $NumeroTelefono;

    /**
     * @var string $Email
     *
     * @ORM\Column(name="Email", type="string", length=255, nullable=true)
     */
    private $Email;

    /**
     * @var boolean $PersonaJuridica
     *
     * @ORM\Column(name="PersonaJuridica", type="boolean", nullable=true)
     */
    private $PersonaJuridica;

    /**
     * @var integer $CodigoPostal
     *
     * @ORM\Column(name="CodigoPostal", type="string", length=50)
     */
    private $CodigoPostal;

    /**
     * @var \DateTime $FechaNacimiento
     *
     * @ORM\Column(name="FechaNacimiento", type="date")
     */
    private $FechaNacimiento;

    /**
     * @var integer $Genero
     *
     * @ORM\Column(name="Genero", type="integer")
     */
    private $Genero;

    /**
     * @ORM\ManyToOne(targetEntity="Pais")
     * @ORM\JoinColumn(name="Pais", referencedColumnName="id")
     */
    protected $Pais;  
    
    /**
     * Set Apellido
     *
     * @param string $apellido
     * @return Persona
     */
    public function setApellido($apellido)
    {
        $this->Apellido = $apellido;
    
        return $this;
    }

    /**
     * Get Apellido
     *
     * @return string 
     */
    public function getApellido()
    {
        return $this->Apellido;
    }

    /**
     * Set Nombre
     *
     * @param string $nombre
     * @return Persona
     */
    public function setNombre($nombre)
    {
        $this->Nombre = $nombre;
    
        return $this;
    }

    /**
     * Get Nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->Nombre;
    }

    /**
     * Set RazonSocial
     *
     * @param string $razonSocial
     * @return Persona
     */
    public function setRazonSocial($razonSocial)
    {
        $this->RazonSocial = $razonSocial;
    
        return $this;
    }

    /**
     * Get RazonSocial
     *
     * @return string 
     */
    public function getRazonSocial()
    {
        return $this->RazonSocial;
    }

    /**
     * Set TipoDocumento
     *
     * @param integer $tipoDocumento
     * @return Persona
     */
    public function setTipoDocumento($tipoDocumento)
    {
        $this->TipoDocumento = $tipoDocumento;
    
        return $this;
    }

    /**
     * Get TipoDocumento
     *
     * @return integer 
     */
    public function getTipoDocumento()
    {
        return $this->TipoDocumento;
    }

    /**
     * Set NumeroDocumento
     *
     * @param integer $numeroDocumento
     * @return Persona
     */
    public function setNumeroDocumento($numeroDocumento)
    {
        $this->NumeroDocumento = $numeroDocumento;
    
        return $this;
    }

    /**
     * Get NumeroDocumento
     *
     * @return integer 
     */
    public function getNumeroDocumento()
    {
        return $this->NumeroDocumento;
    }

    /**
     * Set Calle
     *
     * @param string $calle
     * @return Persona
     */
    public function setCalle($calle)
    {
        $this->Calle = $calle;
    
        return $this;
    }

    /**
     * Get Calle
     *
     * @return string 
     */
    public function getCalle()
    {
        return $this->Calle;
    }

    /**
     * Set NumeroCalle
     *
     * @param integer $numeroCalle
     * @return Persona
     */
    public function setNumeroCalle($numeroCalle)
    {
        $this->NumeroCalle = $numeroCalle;
    
        return $this;
    }

    /**
     * Get NumeroCalle
     *
     * @return integer 
     */
    public function getNumeroCalle()
    {
        return $this->NumeroCalle;
    }

    /**
     * Set NumeroTelefono
     *
     * @param integer $numeroTelefono
     * @return Persona
     */
    public function setNumeroTelefono($numeroTelefono)
    {
        $this->NumeroTelefono = $numeroTelefono;
    
        return $this;
    }

    /**
     * Get NumeroTelefono
     *
     * @return integer 
     */
    public function getNumeroTelefono()
    {
        return $this->NumeroTelefono;
    }

    /**
     * Set Email
     *
     * @param string $email
     * @return Persona
     */
    public function setEmail($email)
    {
        $this->Email = $email;
    
        return $this;
    }

    /**
     * Get Email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->Email;
    }

    /**
     * Set PersonaJuridica
     *
     * @param boolean $personaJuridica
     * @return Persona
     */
    public function setPersonaJuridica($personaJuridica)
    {
        $this->PersonaJuridica = $personaJuridica;
    
        return $this;
    }

    /**
     * Get PersonaJuridica
     *
     * @return boolean 
     */
    public function getPersonaJuridica()
    {
        return $this->PersonaJuridica;
    }

    /**
     * Set AgenteGubernamental
     *
     * @param boolean $agenteGubernamental
     * @return Persona
     */
    public function setAgenteGubernamental($agenteGubernamental)
    {
        $this->AgenteGubernamental = $agenteGubernamental;
    
        return $this;
    }

    /**
     * Get AgenteGubernamental
     *
     * @return boolean 
     */
    public function getAgenteGubernamental()
    {
        return $this->AgenteGubernamental;
    }

    /**
     * Set CodigoPostal
     *
     * @param integer $codigoPostal
     * @return Persona
     */
    public function setCodigoPostal($codigoPostal)
    {
        $this->CodigoPostal = $codigoPostal;
    
        return $this;
    }

    /**
     * Get CodigoPostal
     *
     * @return integer 
     */
    public function getCodigoPostal()
    {
        return $this->CodigoPostal;
    }

    /**
     * Set Piso
     *
     * @param integer $piso
     * @return Persona
     */
    public function setPiso($piso)
    {
        $this->Piso = $piso;
    
        return $this;
    }

    /**
     * Get Piso
     *
     * @return integer 
     */
    public function getPiso()
    {
        return $this->Piso;
    }

    /**
     * Set Puerta
     *
     * @param integer $puerta
     * @return Persona
     */
    public function setPuerta($puerta)
    {
        $this->Puerta = $puerta;
    
        return $this;
    }

    /**
     * Get Puerta
     *
     * @return integer 
     */
    public function getPuerta()
    {
        return $this->Puerta;
    }

    /**
     * Set FechaNacimiento
     *
     * @param \DateTime $fechaNacimiento
     * @return Persona
     */
    public function setFechaNacimiento($fechaNacimiento)
    {
        $this->FechaNacimiento = $fechaNacimiento;
    
        return $this;
    }

    /**
     * Get FechaNacimiento
     *
     * @return \DateTime 
     */
    public function getFechaNacimiento()
    {
        return $this->FechaNacimiento;
    }

    /**
     * Set Genero
     *
     * @param integer $genero
     * @return Persona
     */
    public function setGenero($genero)
    {
        $this->Genero = $genero;
    
        return $this;
    }

    /**
     * Get Genero
     *
     * @return integer 
     */
    public function getGenero()
    {
        return $this->Genero;
    }

    /**
     * Set Pais
     *
     * @param integer $pais
     * @return Persona
     */
    public function setPais($pais)
    {
        $this->Pais = $pais;
    
        return $this;
    }

    /**
     * Get Pais
     *
     * @return integer 
     */
    public function getPais()
    {
        return $this->Pais;
    }
}
