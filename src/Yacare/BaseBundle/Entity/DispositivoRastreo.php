<?php
namespace Yacare\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Rastreo asociado a un Rastreador GPS.
 * 
 * Yacare\BaseBundle\Entity\DispositivoRastreo
 * 
 * @author Ezequiel Riquelme <rezequiel.tdf@gmail.com>
 *
 * @ORM\Table(name="Base_DispostivoRastreo")
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 */
class DispositivoRastreo
{
	use\Tapir\BaseBundle\Entity\ConId;
	use\Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
	
	/*protected $Latitud;
	
	protected $Longitud;*/
	
	/**
	 * @ORM\Column(type="float")
	 */
	protected $Velocidad;
	
	/**
	 * @ORM\Column(type="string", length=50)
	 */
	protected $Rumbo;
	
	/**
	 * @ORM\ManyToOne(targetEntity="\Yacare\BaseBundle\Entity\DispositivoRastreadorGps")
	 * @ORM\JoinColumn(nullable=true)
	 */
	protected $Dispositivo;
	
	/*public function getLatitud()
	{
		return $this->Latitud;
	}
	
	public function setLatitud($Latitud)
	{
		$this->Latitud = $Latitud;
	}
	
	public function getLongitud()
	{
		return $this->Longitud;
	}
	
	public function setLongitud($Longitud)
	{
		$this->Longitud = $Longitud;
	}*/
	
	public function getVelocidad()
	{
		return $this->Velocidad;
	}
	
	public function setVelocidad($Velocidad)
	{
		$this->Velocidad = $Velocidad;
	}
	
	public function getRumbo()
	{
		return $this->Rumbo;
	}
	
	public function setRumbo($Rumbo)
	{
		$this->Rumbo = $Rumbo;
	}
	
	public function getDispositivo()
	{
		return $this->Dispositivo;
	}
	
	public function setDispositivo($Dispositivo)
	{
		$this->Dispositivo = $Dispositivo;
	}
}