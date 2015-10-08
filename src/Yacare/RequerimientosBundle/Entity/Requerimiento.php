<?php
namespace Yacare\RequerimientosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Representa un requerimiento, que puede ser un reclamo, una solicitud, una consulta, etc.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 *
 * @ORM\Entity(repositoryClass="Yacare\RequerimientosBundle\Entity\RequerimientoRepository")
 * @ORM\Table(name="Requerimientos_Requerimiento", indexes={
 *     @ORM\Index(name="Requerimientos_Requerimiento_Encargado", columns={ "Encargado_id" }),
 *     @ORM\Index(name="Requerimientos_Requerimiento_Estado", columns={ "Estado" })
 * })
 */
class Requerimiento
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Tapir\BaseBundle\Entity\ConTokenSimple;
    use \Tapir\BaseBundle\Entity\ConNombre;
    use \Tapir\BaseBundle\Entity\ConNotas;
    use \Tapir\BaseBundle\Entity\Versionable;
    use \Tapir\BaseBundle\Entity\Importable;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;

    public function __construct()
    {
        $this->Novedades = new \Doctrine\Common\Collections\ArrayCollection();
        $this->GenerarToken(1000, 9999);
    }
    
    /**
     * El encargado actual del requerimiento.
     * 
     * El encargado puede ver el requerimiento y cambiar su estado o hacer comentarios.
     * 
     * @var \Yacare\BaseBundle\Entity\Persona
     * 
     * @ORM\ManyToOne(targetEntity="Yacare\BaseBundle\Entity\Persona")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=true)
     */
    private $Encargado;
    
    /**
     * La categoría del requerimiento.
     * 
     * @var \Yacare\RequerimientosBundle\Entity\Categoria
     * 
     * @ORM\ManyToOne(targetEntity="Yacare\RequerimientosBundle\Entity\Categoria")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=true)
     */
    private $Categoria;
    
    /**
     * El usuario que inició el requerimiento, o null si es un usuario anónimo.
     * 
     * @var \Yacare\BaseBundle\Entity\Persona
     * 
     * @ORM\ManyToOne(targetEntity="Yacare\BaseBundle\Entity\Persona")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=true)
     */
    private $Usuario;
    
    /**
     * El nombre del usuario que inició el requerimiento.
     * 
     * Sólo presente si Usuario es null.
     *
     * @var string
     * 
     * @ORM\Column(type="string", nullable=true)
     */
    private $UsuarioNombre;
    
    /**
     * El e-mail del usuario que inició el requerimiento.
     * 
     * Sólo presente si Usuario es null.
     *
     * @var string
     * 
     * @ORM\Column(type="string", nullable=true)
     * @Assert\Email()
     */
    private $UsuarioEmail;
    
    /**
     * La dirección del usuario que inició el requerimiento.
     * 
     * Sólo presente si Usuario es null.
     * 
     * @var string
     * 
     * @ORM\Column(type="string", nullable=true)
     */
    private $UsuarioDireccion;
    
    /**
     * El teléfono del usuario que inició el requerimiento.
     * 
     * Sólo presente si Usuario es null
     * 
     * @var string
     * 
     * @ORM\Column(type="string", nullable=true)
     */
    private $UsuarioTelefono;
    
    /**
     * El estado del requerimiento.
     *
     * @var int
     * 
     * @see getEstadoNombres() getEstadoNombres()
     *  
     * @ORM\Column(type="integer", nullable=false)
     */
    private $Estado = 0;
    
    /**
     * La prioridad del requerimiento.
     *
     * @var int
     * 
     * @see getPrioridadNombres() getPrioridadNombres()
     * 
     * @ORM\Column(type="integer", nullable=true)
     */
    private $Prioridad = 0;
    
    /**
     * La calificación de satisfacción de la resolución del requerimiento, o null si aun no fue calificado.
     * 
     * @var int
     * 
     * @see getCalificacionNombres() getCalificacionNombres()
     * 
     * @ORM\Column(type="integer", nullable=true)
     */
    private $Calificacion = null;
    
    /**
     * Las novedades asociadas a este requerimiento.
     *
     * @ORM\OneToMany(targetEntity="\Yacare\RequerimientosBundle\Entity\Novedad", mappedBy="Requerimiento", 
     *     cascade={ "persist" })
     */
    protected $Novedades;

    /**
     * Obtiene estado pendiente.
     * 
     * @return integer
     */
    public function getEstaPendiente()
    {
        return $this->getEstado() < 50;
    }

    /**
     * Obtiene el número de seguimiento.
     * 
     * @return string
     */
    public function getSeguimientoNumero()
    {
        return $this->id . '-' . $this->Token;
    }

    /**
     * Establece notas adjuntas.
     * 
     * @param string $Notas
     */
    public function setNotas($Notas)
    {
        $this->Notas = $Notas;
        if (strlen($Notas) > 53) {
            $this->setNombre(substr($Notas, 0, 50) . '...');
        } else {
            $this->setNombre($Notas);
        }
        return $this;
    }

    /**
     * Normaliza los nombres de prioridades.
     * 
     * @param integer $tipo rango de prioridades.
     * @return string
     * 
     * @see $Prioridad $Prioridad 
     */
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

    /**
     * Obtiene el nombre normalizado de la prioridad.
     * 
     * @return string
     */
    public function getPrioridadNombre()
    {
        return Requerimiento::getPrioridadNombres($this->getPrioridad());
    }

    /**
     * Normaliza los nombres de estados.
     * 
     * @param integer $tipo rango de estados.
     * @return string
     * 
     * @see $Estado $Estado
     */
    public static function getEstadoNombres($tipo)
    {
        switch ($tipo) {
            case 0:
                return 'Nuevo';
            case 10:
                return 'Iniciado';
            case 20:
                return 'En espera';
            case 80:
                return 'Cancelado';
            case 90:
                return 'Terminado';
            case 99:
                return 'Cerrado';
            default:
                return '';
        }
    }

    /**
     * Obtiene el nombre normalizado del estado.
     * 
     * @return string
     */
    public function getEstadoNombre()
    {
        return Requerimiento::getEstadoNombres($this->getEstado());
    }

    /**
     * Normaliza los nombres de las calificaciones.
     * 
     * @param integer $tipo rango de calificaciones.
     * @return string
     * 
     * @see $Calificacion $Calificacion
     */
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

    /**
     * Obtiene el nombre normalizado de la calificación.
     * 
     * @return string
     */
    public function getCalificacionNombre()
    {
        return Requerimiento::getCalificacionNombres($this->getCalificacion());
    }

    /*** Getters, setters */
    
    /**
     * @ignore
     */
    public function getEncargado()
    {
        return $this->Encargado;
    }

    /**
     * @ignore
     */
    public function setEncargado($Encargado)
    {
        $this->Encargado = $Encargado;
        return $this;
    }

    /**
     * @ignore
     */
    public function getCategoria()
    {
        return $this->Categoria;
    }

    /**
     * @ignore
     */
    public function setCategoria($Categoria)
    {
        $this->Categoria = $Categoria;
        return $this;
    }

    /**
     * @ignore
     */
    public function getUsuario()
    {
        return $this->Usuario;
    }

    /**
     * @ignore
     */
    public function setUsuario($Usuario)
    {
        $this->Usuario = $Usuario;
        return $this;
    }

    /**
     * @ignore
     */
    public function getUsuarioNombre()
    {
        return $this->UsuarioNombre;
    }

    /**
     * @ignore
     */
    public function setUsuarioNombre($UsuarioNombre)
    {
        $this->UsuarioNombre = $UsuarioNombre;
        return $this;
    }

    /**
     * @ignore
     */
    public function getUsuarioEmail()
    {
        return $this->UsuarioEmail;
    }

    /**
     * @ignore
     */
    public function setUsuarioEmail($UsuarioEmail)
    {
        $this->UsuarioEmail = $UsuarioEmail;
        return $this;
    }

    /**
     * @ignore
     */
    public function getUsuarioDireccion()
    {
        return $this->UsuarioDireccion;
    }

    /**
     * @ignore
     */
    public function setUsuarioDireccion($UsuarioDireccion)
    {
        $this->UsuarioDireccion = $UsuarioDireccion;
        return $this;
    }

    /**
     * @ignore
     */
    public function getUsuarioTelefono()
    {
        return $this->UsuarioTelefono;
    }

    /**
     * @ignore
     */
    public function setUsuarioTelefono($UsuarioTelefono)
    {
        $this->UsuarioTelefono = $UsuarioTelefono;
        return $this;
    }

    /**
     * @ignore
     */
    public function getEstado()
    {
        return $this->Estado;
    }

    /**
     * @ignore
     */
    public function setEstado($Estado)
    {
        $this->Estado = $Estado;
        return $this;
    }

    /**
     * @ignore
     */
    public function getPrioridad()
    {
        return $this->Prioridad;
    }

    /**
     * @ignore
     */
    public function setPrioridad($Prioridad)
    {
        $this->Prioridad = $Prioridad;
        return $this;
    }

    /**
     * @ignore
     */
    public function getCalificacion()
    {
        return $this->Calificacion;
    }

    /**
     * @ignore
     */
    public function setCalificacion($Calificacion)
    {
        $this->Calificacion = $Calificacion;
        return $this;
    }

    /**
     * @ignore
     */
    public function getNovedades()
    {
        return $this->Novedades;
    }

    /**
     * @ignore
     */
    public function setNovedades($Novedades)
    {
        $this->Novedades = $Novedades;
        return $this;
    }
}
