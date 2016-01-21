<?php
namespace Tapir\TemplateBundle\Tgen;

/**
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class Bootstrap3Generator extends HtmlGenerator
{
    public function Progress($val, $max = 100, $attr = null) {
        $attr = HtmlGenerator::MergeAttributes($attr, [ 'class' => 'progress' ]);
        
        return $this->Div(
            $this->Div(
                $this->Span(
                    round($val/$max*100) . '% completo',
                    [ 'class' => 'sr-only']
                ),
                [ 'class' => 'progress-bar',
                'role' => 'progressbar',
                'aria-valuemin' => '0',
                'aria-valuemax' => $max,
                'aria-valuenow' => $val,
                'style' => 'width: ' . round($val/$max*100) . '%;' ]
            ),
            $attr);
    }
    
    public function Header1($content, $attr = null) {
        return new Tag('h1', $content, $attr);
    }
    
    public function Header2($content, $attr = null) {
        return new Tag('h2', $content, $attr);
    }
    
    public function Header3($content, $attr = null) {
        return new Tag('h3', $content, $attr);
    }
    
    public function Header4($content, $attr = null) {
        return new Tag('h4', $content, $attr);
    }
    
    public function Span($content , $attr = null) {
        return new Tag('span', $content, $attr);
    }
    
    public function Div($content, $attr = null) {
        return new Tag('div', $content, $attr);
    }
    
    public function Button($content, $attr = null) {
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
            $content = $this->IconAndText($attr['icon'], $content);
            unset($attr['icon']);
        }
    
        return new Tag('a', $content, $attr);
    }
    
    public function Icon($name, $attr = null) {
        $attr = HtmlGenerator::MergeAttributes($attr, array(
            'class' => 'fa fa-' . $name
        ));
    
        return new Tag('i', null, $attr);
    }
    
    public function IconAndText($name, $text, $attr = null) {
        return new Content($this->Icon($name, $attr), ' ' . $text);
    }
}
