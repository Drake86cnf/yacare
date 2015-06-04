<?php
namespace Tapir\AnnotationBundle\Conversion;

use Doctrine\Common\Annotations\AnnotationReader;

class PruebaAnnotationConverter
{
	
	private $reader;
	private $annotationClass = 'Tapir\\AnnotationBundle\\Annotation\PruebaAnnotation';
	
	
	public function __construct (AnnotationReader $reader)
	{
		$this->reader = $reader;
	}
	
	public function convert ($objetoOriginal)
	{
		$objetoConvertido = new \stdClass;
		
		$objetoReflexion = new \ReflectionObject($objetoOriginal);
		
		foreach ($objetoReflexion->getMethods() as $reflexionMetodo)
		{
			//Traigo o busco la annotation @PruebaAnnotation con el lector de annotation
			$annotation = $this->reader->getMethodAnnotation($reflexionMetodo, $this->annotationClass);
			if (null !== $annotation)
			{
				$propertyName = $annotation->getPropertyName();
				
				//Recupera el valor de la propiedad, llamando al método
				$value = $reflexionMetodo->invoke($objetoOriginal);
				
				//Intenta convertir el valor al tipo requerido
				$type = $annotation->getDataType();
				if (false === settype($value, $type)) 
				{
					throw new \RuntimeException(sprintf('No se ha podido convertir el valor al tipo "%s"', $value));
				}
				
				$objetoConvertido = $value;
			}
		}
		
		return $objetoConvertido;
	}

}

