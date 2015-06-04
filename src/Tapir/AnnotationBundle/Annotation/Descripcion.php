<?php
namespace Tapir\AnnotationBundle\Annotation;

/**
 * @Annotation
 */

class Descripcion
{
	public $value;
	
	public function __construct (array $data)
	{
		$this->value = $data['value'];
	}
}