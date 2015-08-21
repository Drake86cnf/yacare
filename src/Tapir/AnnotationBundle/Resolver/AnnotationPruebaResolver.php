<?php
namespace Tapir\AnnotationBundle\Resolver;

use Symfony\Component\HttpFoundation\Request;
use Mmoreram\ControllerExtraBundle\Resolver\Interfaces\AnnotationResolverInterface;
use Mmoreram\ControllerExtraBundle\Annotation\Abstracts\Annotation;

/**
 * Annotation prueba resolver.
 */
class AnnotationPruebaResolver implements AnnotationResolverInterface
{

    public function evaluateAnnotation(Request $request, Annotation $annotation, \ReflectionMethod $method)
    {
        $field = $annotation->getField();
        $entity = $request->attributes->get('entity');
        $request->attributes->set('field', $field);
        
        return $this;
    }
}