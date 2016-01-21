<?php
namespace Tapir\TemplateBundle\Tgen;

/**
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class Bootstrap3Generator extends HtmlGenerator
{
    public function Progress($val, $max = 100, $attr = null) {
        $attr = HtmlGenerator::MergeAttributes($attr, array(
            'class' => 'progress'
        ));
        
        $tag = new Tag('div', $attr);
        return $tag->EmitHtml('
<div class="progress-bar progress-bar-success" role="progressbar"
	aria-valuenow="' . $val . '" aria-valuemin="0"
	aria-valuemax="' . $max . '" style="width: ' . round($val/$max*100) . '%;">
	<span class="sr-only">' . round($val/$max*100) . '% completo</span>
</div>
<div class="progress-bar progress-bar-warning" role="progressbar"
	aria-valuenow="' . ($max - $val) . '"
	aria-valuemin="0" aria-valuemax="' . $max . '"
	style="width: ' . round(100-$val/$max*100) . '%;"></div>
');
    }
    
    
    public function Button($label, $attr = null) {
        $attr = HtmlGenerator::MergeAttributes($attr, array(
            'class' => 'btn btn-default'
        ));
        
        if(array_key_exists('ajax', $attr) && $attr['ajax']) {
            $attr['data-toggle'] = 'ajax-link';
            unset($attr['ajax']);
        } elseif(array_key_exists('modal', $attr) && $attr['modal']) {
            $attr['data-toggle'] = 'modal';
            unset($attr['modal']);
        }
        
        if(array_key_exists('icon', $attr) && $attr['icon']) {
            $label = $this->IconAndText($attr['icon'], $label);
            unset($attr['icon']);
        }
    
        return (new Tag('a', $attr))->EmitHtml($label);
    }
    
    public function Icon($name, $attr = null) {
        $attr = HtmlGenerator::MergeAttributes($attr, array(
            'class' => 'fa fa-' . $name
        ));
    
        return (new Tag('i', $attr))->EmitHtml();
    }
    
    public function IconAndText($name, $text, $attr = null) {
        return $this->Icon($name, $attr) . ' ' . $text;
    }
}
