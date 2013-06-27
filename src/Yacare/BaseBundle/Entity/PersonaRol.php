<?php

namespace Yacare\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use \Symfony\Component\Security\Core\Role\RoleInterface;

/**
 * Yacare\BaseBundle\Entity\PersonaRol
 *
 * @ORM\Table(name="Base_PersonaRol")
 * @ORM\Entity
 */
class PersonaRol implements RoleInterface
{
    use \Yacare\BaseBundle\Entity\Timestampable;
    use \Yacare\BaseBundle\Entity\Versionable;
    use \Yacare\BaseBundle\Entity\Eliminable;
    
    public function __construct()
    {
        $this->Personas = new \Doctrine\Common\Collections\ArrayCollection();
    }      
    
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * 
     */
    private $id;
        
    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $Nombre;    

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $Codigo;

    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    public function setNombre($nombre)
    {
        $this->Nombre = $nombre;
        $codigo = "ROLE_" . strtr(mb_strtoupper($nombre, 'utf-8'), array(
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
            ':' => '_'
        ));
        $this->Codigo = str_replace('__', '_', $codigo);
    }
    
    public function getRole() {
        return $this->Codigo;
    }

    public function getNombre()
    {
        return $this->Nombre;
    }

    public function getCodigo() {
        return $this->Codigo;
    }

    public function setCodigo($Codigo) {
        $this->Codigo = $Codigo;
    }

    /**
     * @ORM\ManyToMany(targetEntity="Persona", mappedBy="Grupos", cascade={"persist"})
     */
    protected $Personas;


    public function __toString() {
        return $this->getNombre();
    }
}
