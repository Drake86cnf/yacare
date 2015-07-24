<?php
namespace Tapir\AnnotationBundle\Data;

use Metadata\MetadataFactoryInterface;

class DescripcionProcesador
{

    private $metadataFactory;

    public function __construct(MetadataFactoryInterface $metadataFactory)
    {
        $this->metadataFactory = $metadataFactory;
    }

    public function fillObjectWithDefaultValues($objeto)
    {
        if (! is_object($objeto)) {
            throw new \InvalidArgumentException('No se recibió ningún objeto.');
        }
        
        $classMetadata = $this->metadataFactory->getMetadataForClass(get_class($objeto));
        /*
         * @var $classMetadata Clase donde se usa la annotation pesonalizada,
         * ya sea una Entidad u otra clase que sea usada dentro de la aplicación.
         */
        
        foreach ($classMetadata->propertyMetadata as $propertyMetadata) {
            
            // @var $propertytMetadata \Tapir\AnnotationBundle\Metadata\PropertyMetadata
            if (isset($propertyMetadata->descripcion)) {
                $propertyMetadata->setValue($objeto, $propertyMetadata->descripcion);
            }
        }
        
        return $objeto;
    }
}