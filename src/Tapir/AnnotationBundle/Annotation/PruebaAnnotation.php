<?php
namespace Tapir\AnnotationBundle\Annotation;

/**
 * @Annotation
 */

class PruebaAnnotation
{
	private $propertyName;
	private $dataType = 'string';
	
	public function __construct($opciones)
	{
		if (isset($opciones['value']))
		{
			$opciones['propertyName'] = $opciones['value'];
			unset($opciones['value']);
		}
		
		foreach ($opciones as $key => $value)
		{
			if (!property_exists($this, $key))
			{
				throw new \InvalidArgumentException(sprintf('La propiedad "%s" no existe', $key));
			}
			
			$this->$key = $value;
		}
	}
	
	public function getPropertyName()
	{
		return $this->propertyName;
	}
	
	public function getDataType()
	{
		return $this->dataType;
	}
}