<?php
namespace Yacare\RequerimientosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\RequerimientosBundle\Entity\RequerimientoNovedad
 *
 * @ORM\Table(name="Requerimientos_Requerimiento",
 * indexes={
 * 	@ORM\Index(name="Requerimientos_Requerimiento_Encargado", columns={ "Encargado" }),
 *  @ORM\Index(name="Requerimientos_Requerimiento_Estado", columns={ "Estado" })
 * })
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 */
class RequerimientoNovedad
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Tapir\BaseBundle\Entity\ConNotas;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;

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
}
