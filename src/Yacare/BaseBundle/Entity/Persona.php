<?php

namespace Yacare\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * YacarSae\BaseBundle\Entity\Persona
 *
 * @ORM\Table(name="Base_Persona", 
 *      uniqueConstraints={
 *          @ORM\UniqueConstraint(name="ImportSrcId", columns={"ImportSrc", "ImportId"})
 *      },
 *      indexes={
 *          @ORM\Index(name="Base_Persona_ImportSrcId", columns={"ImportSrc", "ImportId"}),
 *          @ORM\Index(name="Base_Persona_Documento", columns={"DocumentoTipo", "DocumentoNumero"}),
 *          @ORM\Index(name="Base_Persona_Cuilt", columns={"Cuilt"}),
 *          @ORM\Index(name="Base_Persona_NombreVisible", columns={"NombreVisible"})
 *      }
 * )
 * @ORM\Entity(repositoryClass="Yacare\BaseBundle\Entity\YacareBaseRepository")
 */
class Persona implements UserInterface, \Serializable
{
    use \Yacare\BaseBundle\Entity\ConId;
    use \Yacare\BaseBundle\Entity\ConDomicilio;
    use \Yacare\BaseBundle\Entity\ConImagen;
    use \Yacare\BaseBundle\Entity\Versionable;
    use \Yacare\BaseBundle\Entity\Suprimible;
    use \Yacare\BaseBundle\Entity\Importable;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    
    /**
     * @ORM\ManyToMany(targetEntity="PersonaGrupo", inversedBy="Personas")
     * @ORM\JoinTable(name="Base_Persona_PersonaGrupo")
     */
    private $Grupos;
    
    /**
     * @ORM\ManyToMany(targetEntity="PersonaRol", inversedBy="Personas")
     * @ORM\JoinTable(name="Base_Persona_PersonaRol")
     */
    private $UsuarioRoles;
    
    
    public function __construct()
    {
        $this->Grupos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->UsuarioRoles = new \Doctrine\Common\Collections\ArrayCollection();
        $this->isActive = true;
        $this->salt = md5(uniqid(null, true));
    }


    /**
     * @var string $Apellido
     * @ORM\Column(type="string", length=255)
     */
    private $Apellido;

    /**
     * @var string $Nombre
     * @ORM\Column(type="string", length=255)
     */
    private $Nombre;
    
    /**
     * @var string $NombreVisible
     * @ORM\Column(type="string", length=255)
     */
    private $NombreVisible;
    
    
    /**
     * @ORM\Column(type="string", length=25, unique=true, nullable=true)
     */
    private $Username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Salt = '23d0f70792accd85ccf1b09f892a89d2';                 // Sal predeterminada

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Password = 'VYHNTJyqYCoQQ0UI7V/HKYyJ5Ak06MCxQQFuhwxK';     // Contraseña predeterminada 123456
    
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $PasswordEnc = 'MTIzNDU2';                                  // Contraseña predeterminada 123456, con base64
    

    /**
     * @var string
     * @ORM\Column(type="boolean")
     */
    private $PersonaJuridica = 0;
    
    /**
     * @var string $RazonSocial
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $RazonSocial = null;

    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $DocumentoTipo;

    /**
     * @var string
     * @ORM\Column(type="integer")
     */
    private $DocumentoNumero;
    
    /**
     * @var string
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $Cuilt;

    /**
     * @var string $TelefonoNumero
     * @ORM\Column(type="string", nullable=true)
     */
    private $TelefonoNumero;

    /**
     * @var string $Email
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Email;

    /**
     * @var boolean $SituacionTributaria
     * @ORM\Column(type="integer", nullable=true)
     */
    private $SituacionTributaria;

    /**
     * @var \DateTime $FechaNacimiento
     * @ORM\Column(type="date", nullable=true)
     * @Assert\Type("\DateTime")
     */
    private $FechaNacimiento;

    /**
     * @var integer $Genero
     * @ORM\Column(type="integer", nullable=true)
     */
    private $Genero;

    /**
     * @ORM\ManyToOne(targetEntity="Pais")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $Pais;
    
    
    /* Columnas de importación del municipio de Río Grande */
    
    /**
     * @var string $ImportId
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $Tg06100Id;
    
    /**
     * @var string $ImportId
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $AgenteId;
    
    
    public function getNombreVisible() {
        if($this->RazonSocial)
            $this->NombreVisible = $this->RazonSocial;
        else if($this->Apellido && $this->Nombre)
            $this->NombreVisible = $this->Apellido . ', ' . $this->Nombre;
        else if($this->Nombre)
            $this->NombreVisible = $this->Nombre;
        else
            $this->NombreVisible = $this->Apellido;
        
        return trim($this->NombreVisible, ',');
    }

    public function setNombreVisible($NombreVisible) {
        if($this->RazonSocial)
            $this->NombreVisible = $this->RazonSocial;
        else if($this->Apellido && $this->Nombre)
            $this->NombreVisible = $this->Apellido . ', ' . $this->Nombre;
        else if($this->Nombre)
            $this->NombreVisible = $this->Nombre;
        else
            $this->NombreVisible = $this->Apellido;
        
        $this->NombreVisible = trim($this->NombreVisible, ',');
    }
    
    public function getRoles() {
        $res = $this->UsuarioRoles->toArray();
        if(in_array('ROLE_USUARIO', $res) == false) {
            /*
             * Todos tiene el rol USUARIO
             */
            $res[] = 'ROLE_USUARIO';
        }
        return $res;
    }
    
    public function getPasswordEnc() {
        return base64_decode($this->PasswordEnc);
    }

    public function setPasswordEnc($PasswordEnc) {
        $this->PasswordEnc = base64_encode($PasswordEnc);
    }
    
    public function __toString() {
        return $this->getNombreVisible();
    }
    
    public function eraseCredentials()
    {
    }

    /**
     * @see \Serializable::serialize()
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
        ));
    }

    /**
     * @see \Serializable::unserialize()
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
        ) = unserialize($serialized);
    }

    public function isEqualTo(UserInterface $user)
    {
        return $this->id === $user->getId();
    }
    


    public function getApellido() {
        return $this->Apellido;
    }

    public function setApellido($Apellido) {
        $this->Apellido = $Apellido;
        $this->getNombreVisible();
    }

    public function getNombre() {
        return $this->Nombre;
    }

    public function setNombre($Nombre) {
        $this->Nombre = $Nombre;
        $this->getNombreVisible();
    }

    public function getRazonSocial() {
        return $this->RazonSocial;
        $this->getNombreVisible();
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
    
    public function getCuilt() {
        return $this->Cuilt;
    }

    public function setCuilt($Cuilt) {
        $this->Cuilt = $Cuilt;
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

    public function getFechaNacimiento() {
        return $this->FechaNacimiento;
    }

    public function setFechaNacimiento(\DateTime $FechaNacimiento = null) {
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

    public function getUsername() {
        return $this->Username;
    }

    public function setUsername($Username) {
        $this->Username = $Username;
    }

    public function getSalt() {
        return $this->Salt;
    }

    public function setSalt($Salt) {
        $this->Salt = $Salt;
    }

    public function getPassword() {
        return $this->Password;
    }

    public function setPassword($Password) {
        $this->Password = $Password;
    }
    
    public function getUsuarioRoles() {
        return $this->UsuarioRoles;
    }

    public function setUsuarioRoles($UsuarioRoles) {
        $this->UsuarioRoles = $UsuarioRoles;
    }
    
    public function getTg06100Id() {
        return $this->Tg06100Id;
    }

    public function getAgenteId() {
        return $this->AgenteId;
    }

    public function setTg06100Id($Tg06100Id) {
        $this->Tg06100Id = $Tg06100Id;
    }

    public function setAgenteId($AgenteId) {
        $this->AgenteId = $AgenteId;
    }

}
