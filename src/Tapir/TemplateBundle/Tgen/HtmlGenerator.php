<?php
namespace Tapir\TemplateBundle\Tgen;

/**
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class HtmlGenerator
{
    public static function Render($content) {
        if(is_a($content, 'Tapir\TemplateBundle\Tgen\Tag', false)) {
            return $content->Render();
        } elseif(is_a($content, 'Tapir\TemplateBundle\Tgen\Content', false)) {
            return $content->Render();
        } else {
            return (string)$content;
        }
    }
    
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
