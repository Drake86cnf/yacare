<?php
namespace Tapir\AbmBundle\Helper;

/**
 * Describe un filtro que puede aplicarse a un listado.
 *  
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class Filtro
{
	public $Columna;
	public $ValorActual;
	public $ValoresPosibles;
	
	public function __construct($columna, $valorActual, $valoresPosibles) {
		$this->Columna = $columna;
		$this->ValorActual = $valorActual;
		$this->ValoresPosibles = $valoresPosibles;
	}
	
	/**
	 * Devuelve true si este filtro está en efecto.
	 */
	public function Aplicado() {
		return $this->ValorActual ? true : false;
	}
}