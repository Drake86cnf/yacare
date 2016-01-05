<?php
namespace Tapir\BaseBundle\Helper;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;

class ClassHelper
{
    /**
     * Obtiene los traits usados por una clase,
     */
    public static function ObtenerTraitsRecursivos($classOrObject)
    {
        if (is_string($classOrObject)) {
            $className = $classOrObject;
        } else {
            $className = get_class($classOrObject);
        }
        
        $traits = [];
        do {
            $traits = array_merge(class_uses($className), $traits);
        } while ($className = get_parent_class($className));
        
        foreach ($traits as $trait => $dummy) {
            $traits = array_merge(class_uses($trait), $traits);
        }

        return array_unique($traits);
    }

    public static function UsaTrait($classOrObject, $trait)
    {
        return in_array($trait, ClassHelper::ObtenerTraitsRecursivos($classOrObject));
    }
}
