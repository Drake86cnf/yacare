<?php
namespace Tapir\AnnotationBundle\Annotation;

use Mmoreram\ControllerExtraBundle\Annotation\Abstracts\Annotation;

/**
 * Prueba de 2da annotation.
 * 
 * @Annotation
 */
class AnnotationPrueba extends Annotation
{

    public $field;

    public function getField()
    {
        return $this->field;
    }
}