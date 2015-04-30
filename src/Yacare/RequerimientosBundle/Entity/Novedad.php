<?php
namespace Yacare\RequerimientosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Una novedad relacionada con un requerimiento.
 *
 * @ORM\Table(name="Requerimientos_Requerimiento_Novedad")
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class Novedad
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Tapir\BaseBundle\Entity\ConNotas;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    
    /**
     * El requerimiento al cual pertenece esta novedad.
     *
     * @ORM\ManyToOne(targetEntity="Yacare\RequerimientosBundle\Entity\Requerimiento", inversedBy="Novedades")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=false)
     */
    private $Requerimiento;

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
     * El nuevo estado del requerimiento, o null si el requerimiento continua en el mismo estado.
     *
     * @see Requerimiento::getEstadoNombres()
     * @var int 
     * @ORM\Column(type="integer", nullable=true)
     */
    private $NuevoEstado = null;
    
    
    /**
     * Si es una novedad privada, sólo puede ser vista por los intervinientes.
     *
     * @var int
     * @ORM\Column(type="integer", nullable=false)
     */
    private $Privada = 0;

    
    /*** Getters, setters */
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
	public function getNuevoEstado() {
		return $this->NuevoEstado;
	}
	public function setNuevoEstado($NuevoEstado) {
		$this->NuevoEstado = $NuevoEstado;
		return $this;
	}
    public function getRequerimiento()
    {
        return $this->Requerimiento;
    }
    public function setRequerimiento($Requerimiento)
    {
        $this->Requerimiento = $Requerimiento;
        return $this;
    }
    public function getPrivada()
    {
        return $this->Privada;
    }
    public function setPrivada(int $Privada)
    {
        $this->Privada = $Privada;
        return $this;
    }
 

}
