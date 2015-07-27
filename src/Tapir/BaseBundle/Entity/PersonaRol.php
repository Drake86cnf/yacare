<?php
namespace Tapir\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use \Symfony\Component\Security\Core\Role\RoleInterface;

/**
 * Rol asociable a un usuario.
 *
 * @ORM\Table(name="Base_PersonaRol")
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * 
 * @Tapir\Abm\Nombre("rol de personas")
 * @Tapir\Abm\NombrePlural("roles de personas")
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class PersonaRol implements RoleInterface
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    use \Tapir\BaseBundle\Entity\Versionable;
    use \Tapir\BaseBundle\Entity\Suprimible;

    public function __construct()
    {
        $this->Personas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * El nombre del rol.
     *
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $Nombre;

    /**
     * El código de rol.
     *
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $Codigo;

    /**
     * Las personas que tienen este rol.
     *
     * @ORM\ManyToMany(targetEntity="Yacare\BaseBundle\Entity\Persona", mappedBy="UsuarioRoles", cascade={"persist"})
     */
    protected $Personas;

    /**
     *
     * @ignore
     *
     */
    public function setNombre($nombre)
    {
        $this->Nombre = $nombre;
        $codigo = "ROLE_" . strtr(mb_strtoupper($nombre, 'utf-8'), 
            array(
                'Á' => 'A',
                'É' => 'E',
                'Í' => 'I',
                'Ó' => 'O',
                'Ú' => 'U',
                'À' => 'A',
                'È' => 'E',
                'Ì' => 'I',
                'Ò' => 'O',
                'Ù' => 'U',
                'Ä' => 'A',
                'Ë' => 'E',
                'Ï' => 'I',
                'Ö' => 'O',
                'Ü' => 'U',
                'Ñ' => 'n',
                'Ç' => 'C',
                ' ' => '_',
                ':' => '_'));
        $this->Codigo = str_replace('__', '_', $codigo);
    }

    /**
     *
     * @ignore
     *
     */
    public function getRole()
    {
        return $this->Codigo;
    }

    /**
     *
     * @ignore
     *
     */
    public function getNombre()
    {
        return $this->Nombre;
    }

    /**
     *
     * @ignore
     *
     */
    public function getCodigo()
    {
        return $this->Codigo;
    }

    /**
     *
     * @ignore
     *
     */
    public function setCodigo($Codigo)
    {
        $this->Codigo = $Codigo;
    }

    /**
     *
     * @ignore
     *
     */
    public function __toString()
    {
        return $this->getNombre();
    }
}
