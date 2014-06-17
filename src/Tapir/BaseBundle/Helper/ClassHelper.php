<?php

namespace Tapir\BaseBundle\Helper;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;

class ClassHelper {
    /*
     * Obtiene los traits usados por una clase, 
     */
    public static function ObtenerTraitsRecursivos($class) {
        if(is_string($class) == false) {
            $class = get_class($class);
        }
        $traits = [];
        do {
            $traits = array_merge(class_uses($class), $traits);
        } while($class = get_parent_class($class));
        foreach ($traits as $trait => $same) {
            $traits = array_merge(class_uses($trait), $traits);
        }
        return array_unique($traits);
    }
    
    public static function UsaTrait($class, $trait) {
        return in_array($trait, ClassHelper::ObtenerTraitsRecursivos($class));
    }
}