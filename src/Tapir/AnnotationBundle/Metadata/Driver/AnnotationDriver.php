<?php
namespace Tapir\AnnotationBundle\Metadata\Driver;

use Metadata\Driver\DriverInterface;
use Metadata\MergeableClassMetadata;
use Doctrine\Common\Annotations\AnnotationReader;
use Tapir\AnnotationBundle\Metadata\PropertyMetadata;

class AnnotationDriver implements DriverInterface
{
	protected $reader;

	public function __construct(AnnotationReader $reader)
	{
		$this->reader = $reader;
	}

	public function loadMetadataForClass(\ReflectionClass $class)
	{
		$classMetadata = new MergeableClassMetadata ($class->getName());

		foreach ($class->getProperties() as $reflectionProperty)
		{
			$propertyMetadata = new PropertyMetadata($class->getName(), $reflectionProperty->getName());
				
			$annotation = $this->reader->getPropertyAnnotation($reflectionProperty, 'Tapir\\AnnotationBundle\\Annotation\\Descripcion');
				
			if (null !== $annotation)
			{
				//Un @Descripcion fue encontrado
				$propertyMetadata->descripcion = $annotation->value;
			}
				
			$classMetadata->addPropertyMetadata($propertyMetadata);
		}

		return $classMetadata;
	}
}