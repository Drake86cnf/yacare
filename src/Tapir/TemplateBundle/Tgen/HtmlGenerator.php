<?php
namespace Tapir\TemplateBundle\Tgen;

/**
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class HtmlGenerator
{
    public static function EmitAttributes($attr) {
        if(!$attr) {
            return '';
        }
        
        $res = '';
        foreach($attr as $key => $val) {
            $res .= ' ' . $key . '="' . $val . '"';
        }
        return $res;
    }
    
    public static function MergeAttributes($attr, $attr2) {
        if($attr == null) {
            return $attr2;
        } elseif ($attr2 == null) {
            return $attr;
        }
    
        $res = $attr;
        foreach($attr2 as $key => $val) {
            if(array_key_exists($key, $res)) {
                $res[$key] = $res[$key] . ' ' . $val;
            } else {
                $res[$key] = $val;
            }
        }
    
        return $res;
    }
}
