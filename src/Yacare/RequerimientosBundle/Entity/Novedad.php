<?php
namespace Yacare\RequerimientosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Representa una novedad relacionada con un requerimiento.
 * 
 * Básicamente puede tratarse de un comentario de un usuario o de un mensaje generado automáticamente por el
 * sistema para indicar avances o cambios de estado. 
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 *
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Table(name="Requerimientos_Requerimiento_Novedad")
 */
class Novedad
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Tapir\BaseBundle\Entity\ConNotas;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    
    /**
     * El requerimiento al cual pertenece esta novedad.
     * 
     * @var \Yacare\RequerimientosBundle\Entity\Requerimiento
     *
     * @ORM\ManyToOne(targetEntity="Yacare\RequerimientosBundle\Entity\Requerimiento", inversedBy="Novedades")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=false)
     */
    private $Requerimiento;
    
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
     * El nuevo estado del requerimiento, o null si el requerimiento continua en el mismo estado.
     *
     * @var int
     * 
     * @see getEstadoNombres() getEstadoNombres()
     * 
     * @ORM\Column(type="integer", nullable=true)
     */
    private $NuevoEstado = null;
    
    /**
     * Si es una novedad privada, sólo puede ser vista por los intervinientes.
     * 
     * Si es una novedad pública (Privada=0) puede ser vista por los usuarios anónimos que tengan acceso
     * al requerimiento.
     *
     * @var int
     * 
     * @ORM\Column(type="integer", nullable=false)
     */
    private $Privada = 1;
    
    /**
     * Indica si la novedad es automática.
     * 
     * Las novedades automáticas son las que genera el sistema para registrar avances o cambios de estado.
     *
     * @var int
     * 
     * @ORM\Column(type="integer", nullable=false)
     */
    private $Automatica = 0;

    /*** Getters, setters */
    
    /**
     * @ignore
     */
    public function getRequerimiento()
    {
        return $this->Requerimiento;
    }

    /**
     * @ignore
     */
    public function setRequerimiento($Requerimiento)
    {
        $this->Requerimiento = $Requerimiento;
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
    public function getNuevoEstado()
    {
        return $this->NuevoEstado;
    }

    /**
     * @ignore
     */
    public function setNuevoEstado($NuevoEstado)
    {
        $this->NuevoEstado = $NuevoEstado;
        return $this;
    }

    /**
     * @ignore
     */
    public function getPrivada()
    {
        return $this->Privada;
    }

    /**
     * @ignore
     */
    public function setPrivada($Privada)
    {
        $this->Privada = $Privada;
        return $this;
    }

    /**
     * @ignore
     */
    public function getAutomatica()
    {
        return $this->Automatica;
    }

    /**
     * @ignore
     */
    public function setAutomatica($Automatica)
    {
        $this->Automatica = $Automatica;
        return $this;
    }
}
