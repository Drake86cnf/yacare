<?php
namespace Yacare\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Una persona (física o jurídica).
 *
 * Representa una persona física o jurídica. Es el repositorio principal de
 * personas, que todas las entidades que representan personas (por ejemplo
 * Usuario, Agente, Proveedor, etc.) deben encapsular.
 *
 * @author Ernesto Carrea <equistango@gmail.com>
 *        
 * @ORM\Table(name="Base_Persona", uniqueConstraints={
 *  @ORM\UniqueConstraint(name="ImportSrcId", columns={"ImportSrc", "ImportId"})},
 *  indexes={
 *      @ORM\Index(name="Base_Persona_ImportSrcId", columns={"ImportSrc", "ImportId"}),
 *      @ORM\Index(name="Base_Persona_Documento", columns={"DocumentoTipo", "DocumentoNumero"}),
 *      @ORM\Index(name="Base_Persona_Cuilt", columns={"Cuilt"}),
 *      @ORM\Index(name="Base_Persona_NombreVisible", columns={"NombreVisible"})
 *         })
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 */
class Persona implements UserInterface, \Serializable
{
    use\Tapir\BaseBundle\Entity\ConId;
    use\Tapir\BaseBundle\Entity\ConImagen;
    use\Tapir\BaseBundle\Entity\Versionable;
    use\Tapir\BaseBundle\Entity\Suprimible;
    use\Tapir\BaseBundle\Entity\Importable;
    use\Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    use\Yacare\BaseBundle\Entity\ConDomicilio;
    use\Yacare\BaseBundle\Entity\ConVerificacion;

    /**
     * Los grupos a los cuales pertenece la persona.
     * 
     * @ORM\ManyToMany(targetEntity="PersonaGrupo", inversedBy="Personas")
     * @ORM\JoinTable(name="Base_Persona_PersonaGrupo",
     *  joinColumns={@ORM\JoinColumn(name="Persona_id", referencedColumnName="id", nullable=true)}
     * )
     */
    private $Grupos;
    
    /**
     * Los roles asignados al usuario.
     * 
     * @ORM\ManyToMany(targetEntity="Tapir\BaseBundle\Entity\PersonaRol")
     * @ORM\JoinTable(name="Base_Persona_PersonaRol",
     *  joinColumns={@ORM\JoinColumn(name="Persona_id", referencedColumnName="id", nullable=true)}
     * )
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
     * Los apellidos.
     *
     * @var string $Apellido
     * @ORM\Column(type="string", length=255)
     */
    private $Apellido;

    /**
     * Los nombres de pila.
     *
     * @var string $Nombre
     * @ORM\Column(type="string", length=255)
     */
    private $Nombre;

    /**
     * El nombre que se prefiere para representar a la persona.
     * 
     * Suele ser la combinación de apellido y nombre para las personas físicas
     * y la razón social para las personas jurídicas.
     *
     * @var string $NombreVisible
     * @ORM\Column(type="string", length=255)
     */
    private $NombreVisible;

    /**
     * El nombre de usuario.
     * 
     * @ORM\Column(type="string", length=25, unique=true, nullable=true)
     */
    private $Username;

    /**
     * La sal con la cual se hace el extracto de la contraseña.
     * 
     * @see $Password
     * 
     * @ORM\Column(type="string", length=255)
     */
    private $Salt = '892ddb02bed8aafcddbff7f78f8841d6'; // Sal predeterminada
    
    /**
     * El extracto de la contraseña.
     * 
     * @see $Salt
     * 
     * @ORM\Column(type="string", length=255)
     */
    private $Password = 'ae6786579adda2bfffc032a0693a2f79ec34591d'; // Contraseña predeterminada 123456
    
    /**
     * La contraseña codificada.
     * 
     * @ORM\Column(type="string", length=255)
     */
    private $PasswordEnc = 'MTIzNDU2'; // Contraseña predeterminada 123456, con base64
    
    /**
     * Indica si es persona jurídica (true) o física (false).
     * 
     * @ORM\Column(type="boolean")
     */
    private $PersonaJuridica = false;

    /**
     * La razón social (sólo para personas jurídicas).
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $RazonSocial = null;

    /**
     * El tipo de documento.
     * 
     * @see DocumentoNumero
     * @var integer @ORM\Column(type="integer")
     */
    private $DocumentoTipo;

    /**
     * El tipo de documento.
     *
     * @see DocumentoTipo
     * @var string @ORM\Column(type="integer")
     */
    private $DocumentoNumero;

    /**
     * El CUIL o CUIT.
     *
     * @var string
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $Cuilt;

    /**
     * El o los números de teléfono en formato de texto libre.
     *
     * @var string $TelefonoNumero
     * @ORM\Column(type="string", nullable=true)
     */
    private $TelefonoNumero;
    
    /**
     * El nivel de verificación del campo TelefonoNumero.
     * @var integer
     * @ORM\Column(type="integer", nullable=false)
     */
    private $TelefonoVerificacionNivel = 0;

    /**
     * La dirección de correo electrónico.
     *
     * @var string $Email
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Email;
    
    /**
     * El nivel de verificación del campo Email.
     * @var integer
     * @ORM\Column(type="integer", nullable=false)
     */
    private $EmailVerificacionNivel = 0;

    /**
     * La situación tributaria.
     * 
     * @ORM\Column(type="integer", nullable=true)
     */
    private $SituacionTributaria;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Assert\Type("\DateTime")
     */
    private $FechaNacimiento;

    /**
     * Género (sólo personas físicas).
     *
     * @var integer $Genero
     * @ORM\Column(type="integer", nullable=false)
     */
    private $Genero = 0;
    
    /**
     * Estado civil (sólo personas físicas).
     *
     * @var integer $EstadoCivil
     * @ORM\Column(type="integer", nullable=false)
     */
    private $EstadoCivil = 0;
    

    /**
     * El país de nacionalidad.
     * 
     * @see Pais
     * 
     * @ORM\ManyToOne(targetEntity="Pais")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $Pais;
    
    /* Columnas de importación del municipio de Río Grande */
    
    /**
     * El id original en la tabla del SiGeMI. 
     *
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $Tg06100Id;

    /**
     * El agente asociado, en caso de ser un agente municipal.
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $AgenteId;


    /**
     * Devuelve el campo Cuilt, formateado con guiones (12-12345678-9).
     */
    public function CuiltFormateado() {
        if(strlen($this->Cuilt) == 11) {
            return substr($this->Cuilt, 0, 2) . '-' . substr($this->Cuilt, 2, 8) . '-' . substr($this->Cuilt, 10, 1);
        } else {
            return $this->Cuilt;
        }
    }
    
    
    /*
     * Devuelve el campo Cuilt si tiene. De lo contrario devuelve el documento.
     */
    public function CuiltODocumento() {
        if($this->Cuilt) {
            return $this->CuiltFormateado();
        } else {
            return $this->DocumentoNumero;
        }
    }


    /**
     * Construye un nombre visible.
     * 
     * @see $NombreVisible
     */
    public function getNombreVisible()
    {
        if ($this->RazonSocial) {
            $this->NombreVisible = $this->RazonSocial;
        } else 
            if ($this->Apellido && $this->Nombre) {
                $this->NombreVisible = $this->Apellido . ', ' . $this->Nombre;
            } else 
                if ($this->Nombre) {
                    $this->NombreVisible = $this->Nombre;
                } else {
                    $this->NombreVisible = $this->Apellido;
                }
        
        return trim($this->NombreVisible, ',');
    }

    public function setNombreVisible($NombreVisible)
    {
        if ($this->RazonSocial) {
            $this->NombreVisible = $this->RazonSocial;
        } else 
            if ($this->Apellido && $this->Nombre) {
                $this->NombreVisible = $this->Apellido . ', ' . $this->Nombre;
            } else 
                if ($this->Nombre) {
                    $this->NombreVisible = $this->Nombre;
                } else {
                    $this->NombreVisible = $this->Apellido;
                }
        
        $this->NombreVisible = trim($this->NombreVisible, ',');
    }
    
    
    public static function GenerosNombres($genero) {
        switch($genero) {
            case 0: return 'Sin especificar';
            case 1: return 'Masculino';
            case 2: return 'Femenino';
            case 3: return 'Otro';
            default: return 'n/a';
        }
    }
    
    public static function EstadosCivilesNombres($genero) {
        switch($genero) {
            case 0: return 'Sin especificar';
            case 1: return 'Soltero/a';
            case 2: return 'Casado/a';
            case 3: return 'Divorciado/a';
            case 4: return 'Viudo/a';
            case 5: return 'En concubinato';
            case 6: return 'Separado/a';
            default: return 'n/a';
        }
    }
    
    
    
    public function getGeneroNombre() {
        return Persona::GenerosNombres($this->getGenero());
    }
    
    public function getEstadoCivilNombre() {
        return Persona::EstadosCivilesNombres($this->getEstadoCivil());
    }
    
    
    public function PuedeAcceder() {
        return $this->getUsername() && $this->getPasswordEnc();
    }

    public function getRoles()
    {
        $res = $this->UsuarioRoles->toArray();
        if ($this->PuedeAcceder() && in_array('ROLE_USUARIO', $res) == false) {
            /*
             * Todos los usuarios tienen el rol USUARIO (simpre que tengan una contraseña)
             */
            $res[] = 'ROLE_USUARIO';
        }
        return $res;
    }

    /**
     * @ignore
     */
    public function setUsername($Username)
    {
        $this->Username = strtolower($Username);
    }

    public function getPasswordEnc()
    {
        return base64_decode($this->PasswordEnc);
    }

    public function setPasswordEnc($PasswordEnc)
    {
        $this->PasswordEnc = base64_encode($PasswordEnc);
        
        // Actualizo la sal y la contraseña con hash
        /* $this->setSalt(md5(uniqid(null, true)));
        
        $factory = $this->get('security.encoder_factory');
        $encoder = $factory->getEncoder($this);
        $encoded_password = $encoder->encodePassword($this->getPasswordEnc(), $this->getSalt());
        $this->setPassword($encoded_password); */
    }

    public function __toString()
    {
        return $this->getNombreVisible();
    }

    public function eraseCredentials()
    {}

    /**
     *
     * @see \Serializable::serialize()
     */
    public function serialize()
    {
        return serialize(array(
            $this->id
        ));
    }

    /**
     * @ignore
     * @see \Serializable::unserialize()
     */
    public function unserialize($serialized)
    {
        list ($this->id, ) = unserialize($serialized);
    }

    /**
     * @ignore
     */
    public function isEqualTo(UserInterface $user)
    {
        return $this->id === $user->getId();
    }

    /**
     * @ignore
     */
    public function getApellido()
    {
        return $this->Apellido;
    }

    /**
     * @ignore
     */
    public function setApellido($Apellido)
    {
        $this->Apellido = $Apellido;
        $this->getNombreVisible();
    }

    /**
     * @ignore
     */
    public function getNombre()
    {
        return $this->Nombre;
    }

    /**
     * @ignore
     */
    public function setNombre($Nombre)
    {
        $this->Nombre = $Nombre;
        $this->getNombreVisible();
    }

    /**
     * @ignore
     */
    public function getRazonSocial()
    {
        return $this->RazonSocial;
        $this->getNombreVisible();
    }

    /**
     * @ignore
     */
    public function setRazonSocial($RazonSocial)
    {
        $this->RazonSocial = $RazonSocial;
    }

    /**
     * @ignore
     */
    public function getDocumentoTipo()
    {
        return $this->DocumentoTipo;
    }

    /**
     * @ignore
     */
    public function setDocumentoTipo($DocumentoTipo)
    {
        $this->DocumentoTipo = $DocumentoTipo;
    }

    /**
     * @ignore
     */
    public function getDocumentoNumero()
    {
        return $this->DocumentoNumero;
    }

    /**
     * @ignore
     */
    public function setDocumentoNumero($DocumentoNumero)
    {
        $this->DocumentoNumero = $DocumentoNumero;
    }

    /**
     * @ignore
     */
    public function getCuilt()
    {
        return $this->Cuilt;
    }

    /**
     * @ignore
     */
    public function setCuilt($Cuilt)
    {
        $this->Cuilt = $Cuilt;
    }

    /**
     * @ignore
     */
    public function getTelefonoNumero()
    {
        return $this->TelefonoNumero;
    }

    /**
     * @ignore
     */
    public function setTelefonoNumero($TelefonoNumero)
    {
        $this->TelefonoNumero = $TelefonoNumero;
    }

    /**
     * @ignore
     */
    public function getEmail()
    {
        return $this->Email;
    }

    /**
     * @ignore
     */
    public function setEmail($Email)
    {
        $this->Email = $Email;
    }

    /**
     * @ignore
     */
    public function getSituacionTributaria()
    {
        return $this->SituacionTributaria;
    }

    /**
     * @ignore
     */
    public function setSituacionTributaria($SituacionTributaria)
    {
        $this->SituacionTributaria = $SituacionTributaria;
    }

    /**
     * @ignore
     */
    public function getFechaNacimiento()
    {
        return $this->FechaNacimiento;
    }

    /**
     * @ignore
     */
    public function setFechaNacimiento(\DateTime $FechaNacimiento = null)
    {
        $this->FechaNacimiento = $FechaNacimiento;
    }

    /**
     * @ignore
     */
    public function getGenero()
    {
        return $this->Genero;
    }

    /**
     * @ignore
     */
    public function setGenero($Genero)
    {
        $this->Genero = $Genero;
    }

    /**
     * @ignore
     */
    public function getPersonaJuridica()
    {
        return $this->PersonaJuridica;
    }

    /**
     * @ignore
     */
    public function setPersonaJuridica($PersonaJuridica)
    {
        $this->PersonaJuridica = $PersonaJuridica;
    }

    /**
     * @ignore
     */
    public function getPais()
    {
        return $this->Pais;
    }

    /**
     * @ignore
     */
    public function setPais($Pais)
    {
        $this->Pais = $Pais;
    }

    /**
     * @ignore
     */
    public function getGrupos()
    {
        return $this->Grupos;
    }

    /**
     * @ignore
     */
    public function setGrupos($Grupos)
    {
        $this->Grupos = $Grupos;
    }

    /**
     * @ignore
     */
    public function getUsername()
    {
        return $this->Username;
    }


    /**
     * @ignore
     */
    public function getSalt()
    {
        return $this->Salt;
    }

    /**
     * @ignore
     */
    public function setSalt($Salt)
    {
        $this->Salt = $Salt;
    }

    /**
     * @ignore
     */
    public function getPassword()
    {
        return $this->Password;
    }

    /**
     * @ignore
     */
    public function setPassword($Password)
    {
        $this->Password = $Password;
    }

    /**
     * @ignore
     */
    public function getUsuarioRoles()
    {
        return $this->UsuarioRoles;
    }

    /**
     * @ignore
     */
    public function setUsuarioRoles($UsuarioRoles)
    {
        $this->UsuarioRoles = $UsuarioRoles;
    }

    /**
     * @ignore
     */
    public function getTg06100Id()
    {
        return $this->Tg06100Id;
    }

    /**
     * @ignore
     */
    public function getAgenteId()
    {
        return $this->AgenteId;
    }

    /**
     * @ignore
     */
    public function setTg06100Id($Tg06100Id)
    {
        $this->Tg06100Id = $Tg06100Id;
    }

    /**
     * @ignore
     */
    public function setAgenteId($AgenteId)
    {
        $this->AgenteId = $AgenteId;
    }

    /**
     * @ignore
     */
    public function getVerificacionNivel()
    {
        return $this->VerificacionNivel;
    }

    /**
     * @ignore
     */
    public function setVerificacionNivel($VerificacionNivel)
    {
        $this->VerificacionNivel = $VerificacionNivel;
    }

    /**
    * @ignore
    */
    public function getEstadoCivil()
    {
        return $this->EstadoCivil;
    }

    /**
    * @ignore
    */
    public function setEstadoCivil($EstadoCivil)
    {
        $this->EstadoCivil = $EstadoCivil;
        return $this;
    }

    public function getTelefonoVerificacionNivel()
    {
        return $this->TelefonoVerificacionNivel;
    }

    public function setTelefonoVerificacionNivel($TelefonoVerificacionNivel)
    {
        $this->TelefonoVerificacionNivel = $TelefonoVerificacionNivel;
        return $this;
    }

    public function getEmailVerificacionNivel()
    {
        return $this->EmailVerificacionNivel;
    }

    public function setEmailVerificacionNivel($EmailVerificacionNivel)
    {
        $this->EmailVerificacionNivel = $EmailVerificacionNivel;
        return $this;
    }
 
}
