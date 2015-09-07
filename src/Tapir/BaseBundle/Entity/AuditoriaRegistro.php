<?php
namespace Tapir\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use \Symfony\Component\Security\Core\Role\RoleInterface;

/**
 * Una entrada en el registro de auditoría (log).
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 *
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Table(name="Base_Auditoria")
 */
class AuditoriaRegistro
{
    use \Tapir\BaseBundle\Entity\ConId;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }
    
    /**
     * La fecha y hora del evento.
     *
     * @var \DateTime
     * 
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $createdAt;
    
    /**
     * El nombre de la estación de trabajo o la IP del cliente.
     *
     * @var string
     * 
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $Estacion;
    
    /**
     * La acción ejecutada (editar, eliminar, etc.).
     *
     * @var string
     * 
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $Accion;
    
    /**
     * La tabla o clase sobre la cual se ejecutó la acción.
     *
     * @var string
     * 
     * @see $ElementoId $ElementoId
     * 
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ElementoTipo;
    
    /**
     * El id del elemento sobre el cual se ejecutó la acción.
     *
     * @var integer
     * 
     * @see $ElementoTipo $ElementoTipo
     * 
     * @ORM\Column(type="integer", nullable=true)
     */
    private $ElementoId;
    
    /**
     * Una descripción del conjunto de cambios en formato JSON.
     *
     * @var string
     * 
     * @ORM\Column(type="text", nullable=true)
     */
    private $Cambios = null;
    
    /**
     * El id del usuario que ejecutó la acción.
     *
     * @var int
     * 
     * @ORM\Column(name="usuario", type="integer", nullable=true)
     */
    private $Usuario;

    /**
     * @ignore
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @ignore
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @ignore
     */
    public function getEstacion()
    {
        return $this->Estacion;
    }

    /**
     * @ignore
     */
    public function setEstacion($Estacion)
    {
        $this->Estacion = $Estacion;
        return $this;
    }

    /**
     * @ignore
     */
    public function getAccion()
    {
        return $this->Accion;
    }

    /**
     * @ignore
     */
    public function setAccion($Accion)
    {
        $this->Accion = $Accion;
        return $this;
    }

    /**
     * @ignore
     */
    public function getElementoTipo()
    {
        return $this->ElementoTipo;
    }

    /**
     * @ignore
     */
    public function setElementoTipo($ElementoTipo)
    {
        $this->ElementoTipo = $ElementoTipo;
        return $this;
    }

    /**
     * @ignore
     */
    public function getElementoId()
    {
        return $this->ElementoId;
    }

    /**
     * @ignore
     */
    public function setElementoId($ElementoId)
    {
        $this->ElementoId = $ElementoId;
        return $this;
    }

    /**
     * @ignore
     */
    public function getCambios()
    {
        return $this->Cambios;
    }

    /**
     * @ignore
     */
    public function setCambios($Cambios)
    {
        $this->Cambios = $Cambios;
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
}
