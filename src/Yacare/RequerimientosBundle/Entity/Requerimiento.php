<?php
namespace Yacare\RequerimientosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Representa un requerimiento, que puede ser un reclamo, una solicitud, una denuncia, etc.
 *
 * @ORM\Table(name="Requerimientos_Requerimiento",
 * indexes={
 *      @ORM\Index(name="Requerimientos_Requerimiento_Encargado", columns={ "Encargado_id" }),
 *      @ORM\Index(name="Requerimientos_Requerimiento_Estado", columns={ "Estado" })
 * })
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class Requerimiento
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Tapir\BaseBundle\Entity\ConNotas;
    use \Tapir\BaseBundle\Entity\Versionable;
    use \Tapir\BaseBundle\Entity\Importable;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    
    public function __construct()
    {
        $this->Novedades = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * El encargado actual del requerimiento.
     *
     * @ORM\ManyToOne(targetEntity="Yacare\BaseBundle\Entity\Persona")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=true)
     */
    private $Encargado;
    
    
    /**
     * La categoría del requerimiento.
     *
     * @ORM\ManyToOne(targetEntity="Yacare\RequerimientosBundle\Entity\Categoria")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=true)
     */
    private $Categoria;
    
    
    /**
     * El usuario que inició el requerimiento, o null si es un usuario anónimo.
     *
     * @ORM\ManyToOne(targetEntity="Yacare\BaseBundle\Entity\Persona")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=true)
     */
    private $Usuario;
    
    
    /**
     * El nombre del usuario que inició el requerimiento.
     *
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $UsuarioNombre;

    
    /**
     * El e-mail del usuario que inició el requerimiento.
     *
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $UsuarioEmail;
    

    /**
     * El estado del requerimiento.
     *
     * @see getEstadoNombres()
     * @var int 
     * @ORM\Column(type="integer", nullable=false)
     */
    private $Estado = 0;
    
    
    /**
     * La prioridad del requerimiento.
     *
     * @var int
     * @ORM\Column(type="integer", nullable=true)
     */
    private $Prioridad = 0;
    
    
    /**
     * La calificación de satisfacción de la resolución del requerimiento, o null si aun no fue calificado.
     *
     * @var int
     * @ORM\Column(type="integer", nullable=true)
     */
    private $Calificacion = null;
    
    
    /**
     * Las novedades asociadas a este requerimiento.
     *
     * @ORM\OneToMany(targetEntity="\Yacare\RequerimientosBundle\Entity\Novedad", mappedBy="Requerimiento", cascade={ "persist" })
     */
    protected $Novedades;
    
    
    
    public function __toString() {
        return 'Requerimiento Nº ' . $this->getId();
    }
    
    public static function getPrioridadNombres($tipo)
    {
        switch ($tipo) {
            case 0:
                return 'Baja';
            case 1:
                return 'Media';
            case 2:
                return 'Alta';
            default:
                return '';
        }
    }
    
    public function getPrioridadNombre()
    {
        return Requerimiento::getPrioridadNombres($this->getPrioridad());
    }
    

    public static function getEstadoNombres($tipo)
    {
        switch ($tipo) {
            case 0:
                return 'Nuevo';
            case 10:
                return 'Iniciado';
            case 20:
                return 'En espera';
            case 90:
                return 'Terminado';
            case 99:
            	return 'Cerrado';
            default:
                return '';
        }
    }

    public function getEstadoNombre()
    {
    	return Requerimiento::getEstadoNombres($this->getEstado());
    }
    
    
    public static function getCalificacionNombres($tipo)
    {
    	switch ($tipo) {
    		case 1:
    			return 'Muy mala';
    		case 2:
    			return 'Mala';
    		case 3:
    			return 'Regular';
    		case 4:
    			return 'Buena';
    		case 5:
    			return 'Muy buena';
    		default:
    			return '';
    	}
    }
    public function getCalificacionNombre()
    {
    	return Requerimiento::getCalificacionNombres($this->getCalificacion());
    }
    
    
    /*** Getters, setters */
	public function getEncargado() {
		return $this->Encargado;
	}
	public function setEncargado($Encargado) {
		$this->Encargado = $Encargado;
		return $this;
	}
	public function getUsuario() {
		return $this->Usuario;
	}
	public function setUsuario($Usuario) {
		$this->Usuario = $Usuario;
		return $this;
	}
	public function getUsuarioNombre() {
		return $this->UsuarioNombre;
	}
	public function setUsuarioNombre($UsuarioNombre) {
		$this->UsuarioNombre = $UsuarioNombre;
		return $this;
	}
	public function getUsuarioEmail() {
		return $this->UsuarioEmail;
	}
	public function setUsuarioEmail($UsuarioEmail) {
		$this->UsuarioEmail = $UsuarioEmail;
		return $this;
	}
	public function getEstado() {
		return $this->Estado;
	}
	public function setEstado($Estado) {
		$this->Estado = $Estado;
		return $this;
	}
	public function getCalificacion() {
		return $this->Calificacion;
	}
	public function setCalificacion($Calificacion) {
		$this->Calificacion = $Calificacion;
		return $this;
	}
    public function getNovedades()
    {
        return $this->Novedades;
    }
    public function setNovedades($Novedades)
    {
        $this->Novedades = $Novedades;
        return $this;
    }
    public function getPrioridad()
    {
        return $this->Prioridad;
    }
    public function setPrioridad($Prioridad)
    {
        $this->Prioridad = $Prioridad;
        return $this;
    }
    public function getCategoria()
    {
        return $this->Categoria;
    }
    public function setCategoria($Categoria)
    {
        $this->Categoria = $Categoria;
        return $this;
    }
}
