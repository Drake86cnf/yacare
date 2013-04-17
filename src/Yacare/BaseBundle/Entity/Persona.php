<?php

namespace Yacare\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\BaseBundle\Entity\Persona
 *
 * @ORM\Table(name="Base_Persona")
 * @ORM\Entity
 */
class Persona
{
    use \Yacare\BaseBundle\Entity\Timestampable;
    
    /**
     * @ORM\ManyToMany(targetEntity="PersonaGrupo", inversedBy="Personas")
     * @ORM\JoinTable(name="Base_Persona_PersonaGrupo")
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
     * @var string $UsuarioNombre
     *
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $UsuarioNombre;
    

    /**
     * @var string $PersonaJuridica
     *
     * @ORM\Column(type="boolean")
     */
    private $PersonaJuridica;
    
    
    /**
     * @var string $RazonSocial
     *
     * @ORM\Column(name="RazonSocial", type="string", length=255, nullable=true)
     */
    private $RazonSocial = null;

    /**
     * @var integer $DocumentoTipo
     *
     * @ORM\Column(type="integer")
     */
    private $DocumentoTipo;

    /**
     * @var integer $DocumentoNumero
     *
     * @ORM\Column(type="integer")
     */
    private $DocumentoNumero;

    /**
     * @var string $DomicilioCalle
     *
     * @ORM\Column(name="Calle", type="string", length=255)
     */
    private $DomicilioCalle;

    /**
     * @var integer $DomicilioNumero
     *
     * @ORM\Column(type="integer")
     */
    private $DomicilioNumero;

    /**
     * @var integer $DomicilioPiso
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $DomicilioPiso;

    /**
     * @var integer $DomicilioPuerta
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $DomicilioPuerta;

    /**
     * @var integer $TelefonoNumero
     *
     * @ORM\Column(type="integer")
     */
    private $TelefonoNumero;

    /**
     * @var string $Email
     *
     * @ORM\Column(name="Email", type="string", length=255, nullable=true)
     */
    private $Email;

    /**
     * @var boolean $SituacionTributaria
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $SituacionTributaria;

    /**
     * @var integer $DomicilioCodigoPostal
     *
     * @ORM\Column(type="string", length=50)
     */
    private $DomicilioCodigoPostal;

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

    
    public function getAgente() {
        return $this->Agente;
    }

    public function setAgente($Agente) {
        $this->Agente = $Agente;
    }

    public function getApellido() {
        return $this->Apellido;
    }

    public function setApellido($Apellido) {
        $this->Apellido = $Apellido;
    }

    public function getNombre() {
        return $this->Nombre;
    }

    public function setNombre($Nombre) {
        $this->Nombre = $Nombre;
    }

    public function getUsuarioNombre() {
        return $this->UsuarioNombre;
    }

    public function setUsuarioNombre($UsuarioNombre) {
        $this->UsuarioNombre = $UsuarioNombre;
    }

    public function getRazonSocial() {
        return $this->RazonSocial;
    }

    public function setRazonSocial($RazonSocial) {
        $this->RazonSocial = $RazonSocial;
    }

    public function getDocumentoTipo() {
        return $this->DocumentoTipo;
    }

    public function setDocumentoTipo($DocumentoTipo) {
        $this->DocumentoTipo = $DocumentoTipo;
    }

    public function getDocumentoNumero() {
        return $this->DocumentoNumero;
    }

    public function setDocumentoNumero($DocumentoNumero) {
        $this->DocumentoNumero = $DocumentoNumero;
    }

    public function getDomicilioCalle() {
        return $this->DomicilioCalle;
    }

    public function setDomicilioCalle($DomicilioCalle) {
        $this->DomicilioCalle = $DomicilioCalle;
    }

    public function getDomicilioNumero() {
        return $this->DomicilioNumero;
    }

    public function setDomicilioNumero($DomicilioNumero) {
        $this->DomicilioNumero = $DomicilioNumero;
    }

    public function getDomicilioPiso() {
        return $this->DomicilioPiso;
    }

    public function setDomicilioPiso($DomicilioPiso) {
        $this->DomicilioPiso = $DomicilioPiso;
    }

    public function getDomicilioPuerta() {
        return $this->DomicilioPuerta;
    }

    public function setDomicilioPuerta($DomicilioPuerta) {
        $this->DomicilioPuerta = $DomicilioPuerta;
    }

    public function getTelefonoNumero() {
        return $this->TelefonoNumero;
    }

    public function setTelefonoNumero($TelefonoNumero) {
        $this->TelefonoNumero = $TelefonoNumero;
    }

    public function getEmail() {
        return $this->Email;
    }

    public function setEmail($Email) {
        $this->Email = $Email;
    }

    public function getSituacionTributaria() {
        return $this->SituacionTributaria;
    }

    public function setSituacionTributaria($SituacionTributaria) {
        $this->SituacionTributaria = $SituacionTributaria;
    }

    public function getDomicilioCodigoPostal() {
        return $this->DomicilioCodigoPostal;
    }

    public function setDomicilioCodigoPostal($DomicilioCodigoPostal) {
        $this->DomicilioCodigoPostal = $DomicilioCodigoPostal;
    }

    public function getFechaNacimiento() {
        return $this->FechaNacimiento;
    }

    public function setFechaNacimiento(\DateTime $FechaNacimiento) {
        $this->FechaNacimiento = $FechaNacimiento;
    }

    public function getGenero() {
        return $this->Genero;
    }

    public function setGenero($Genero) {
        $this->Genero = $Genero;
    }
    
    public function getPersonaJuridica() {
        return $this->PersonaJuridica;
    }

    public function setPersonaJuridica($PersonaJuridica) {
        $this->PersonaJuridica = $PersonaJuridica;
    }
    
    public function getPais() {
        return $this->Pais;
    }

    public function setPais($Pais) {
        $this->Pais = $Pais;
    }

    public function getGrupos() {
        return $this->Grupos;
    }

    public function setGrupos($Grupos) {
        $this->Grupos = $Grupos;
    }

}
