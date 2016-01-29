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
    
    public function Link($content, $attr = null) {
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
    
        if(array_key_exists('tag', $attr) && $attr['tag'] == 'button') {
            return new Tag('button', $content, $attr);
        } else {
            return new Tag('a', $content, $attr);
        }
    }
    
    public function UnorderedList($content, $attr = null) {
        $Items = new Content();
        foreach($content as $item) {
            $Items->AddContent($this->ListItem($item));
        }
        return new Tag('ul', $Items, $attr);
    }
    
    public function OrderedList($content, $attr = null) {
        $Items = new Content();
        foreach($content as $item) {
            $Items->AddContent($this->ListItem($item));
        }
        return new Tag('ol', $Items, $attr);
    }
    
    public function ListItem($content, $attr = null) {
        if(is_array($content) && count($content) == 2) {
            return new Tag('li', $this->Link($content[0], [ 'href' => $content[1] ]));
        } elseif(is_string($content) && $content == 'bootstrap-divider') {
            return new Tag('li', '', [ 'role' => 'separator', 'class' => 'divider' ]);
        } else {
            return new Tag('li', $content, $attr = null);
        }
    }

    public function DropdownButton($label, $content, $attr = null) {
        
        $attr = HtmlGenerator::MergeAttributes($attr, [ 
            'class' => 'btn btn-default dropdown-toggle',
            'aria-expanded' => 'false',
            'aria-haspopup' => 'true',
            'data-toggle' => 'dropdown',
            'tag' => 'button'
        ]);
        
        if(array_key_exists('menu-right', $attr) && $attr['menu-right']) {
            $MenuRight = true;
            unset($attr['menu-right']);
        } else {
            $MenuRight = false;
        }
        
        return $this->Div(
            new Content(
                $this->Button(
                    new Content($label, ' ', $this->Span('', [ 'class' => 'caret'])),
                    $attr
                ),
                $this->UnorderedList(
                    $content,
                    [ 'class' => 'dropdown-menu' . ($MenuRight ? ' dropdown-menu-right' : '') ])
                ),
            [ 'class' => 'btn-group' ]);
    }
    
    public function Icon($name, $attr = null) {
        $attr = HtmlGenerator::MergeAttributes($attr, array(
            'class' => 'fa fa-' . $name
        ));
        
        if(array_key_exists('fw', $attr) && $attr['fw']) {
            $attr = HtmlGenerator::MergeAttributes($attr, array(
                'class' => 'fa-fw'
            ));
            unset($attr['fw']);
        }
    
        return new Tag('i', null, $attr);
    }
    
    public function IconAndText($name, $text, $attr = null) {
        return new Content($this->Icon($name, $attr), ' ' . $text);
    }
}
