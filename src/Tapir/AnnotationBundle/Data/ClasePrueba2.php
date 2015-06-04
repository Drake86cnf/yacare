<?php
namespace Tapir\AnnotationBundle\Data;

use Tapir\AnnotationBundle\Annotation\Descripcion;
use Tapir\AnnotationBundle\Annotation\AnotherValue;

class ClasePrueba2
{
	/**
	 * @var string Variable usada para la annotation personalizada.
	 * 
	 * En esta variable se almacenará el valor o el contenido de la annotation personalizada 'Descripcion'
	 * para más adelante, ser accedida, e impresa en pantalla.
	 * 
	 * @Descripcion("Mario Ezequiel Riquelme")
	 */
	private $AnnoName;
	
	/**
	 * @ignore
	 * 
	 * @return string
	 */
	public function getAnnoName()
	{
		return $this->AnnoName;
	}
}