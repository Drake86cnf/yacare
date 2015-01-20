<?php
namespace Tapir\BaseBundle\Model\Auditable;

use Doctrine\ORM\Mapping as ORM;
use \Symfony\Component\Security\Core\Role\RoleInterface;

/**
 * Una entrada en el registro de auditoría (log)
 *
 * @ORM\Table(name="sys_log")
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class Registro
{
    use \Tapir\BaseBundle\Entity\ConIdMetodos;

    /**
     * @var integer
     * @ORM\Column(name="id_log", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
    /**
     * La fecha y hora del evento.
     *
     * @var \DateTime
     * @ORM\Column(name="fecha", type="datetime", nullable=true)
     */
    private $Fecha;
    
    /**
     * El nombre de la estación de trabajo o la IP del cliente.
     *
     * @var string
     * @ORM\Column(name="estacion", type="string", length=255, nullable=false)
     */
    private $Estacion;
    
    /**
     * La acción ejecutada (editar, eliminar, etc.).
     * 
     * @var string
     * @ORM\Column(name="comando", type="string", length=255, nullable=false)
     */
    private $Accion;
    
    /**
     * La tabla o clase sobre la cual se ejecutó la acción.
     * 
     * @var string
     * @ORM\Column(name="tabla", type="string", length=255, nullable=true)
     * 
     * @see ElementoId
     */
    private $ElementoTipo;
    
    /**
     * El id del elemento sobre el cual se ejecutó la acción.
     * 
     * @var integer
     * @ORM\Column(name="item_id", type="integer", nullable=true)
     * 
     * @see ElementoTipo
     */
    private $ElementoId;
    
    /**
     * Datos adicionales.
     *
     * @var string
     * @ORM\Column(name="extra1", type="text", nullable=true)
     */
    private $Extra;
    
    /**
     * El id del usuario que ejecutó la acción.
     * 
     * @var int
     * @ORM\Column(name="usuario", type="integer", nullable=true)
     */
    private $Usuario;

    
    
    public function getFecha()
    {
        return $this->Fecha;
    }

    public function setFecha($Fecha)
    {
        $this->Fecha = $Fecha;
        return $this;
    }

    public function getEstacion()
    {
        return $this->Estacion;
    }

    public function setEstacion($Estacion)
    {
        $this->Estacion = $Estacion;
        return $this;
    }

    public function getAccion()
    {
        return $this->Accion;
    }

    public function setAccion($Accion)
    {
        $this->Accion = $Accion;
        return $this;
    }

    public function getElementoTipo()
    {
        return $this->ElementoTipo;
    }

    public function setElementoTipo($ElementoTipo)
    {
        $this->ElementoTipo = $ElementoTipo;
        return $this;
    }

    public function getElementoId()
    {
        return $this->ElementoId;
    }

    public function setElementoId($ElementoId)
    {
        $this->ElementoId = $ElementoId;
        return $this;
    }

    public function getExtra()
    {
        return $this->Extra;
    }

    public function setExtra($Extra)
    {
        $this->Extra = $Extra;
        return $this;
    }

    public function getUsuario()
    {
        return $this->Usuario;
    }

    public function setUsuario($Usuario)
    {
        $this->Usuario = $Usuario;
        return $this;
    }
}