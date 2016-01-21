<?php
namespace Tapir\TemplateBundle\Tgen;

/**
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class Tag
{
    public $Name, $Attr, $Content;
    
    public function __construct($name, $content = null, $attr = null) {
        $this->Name = $name;
        $this->Content = $content;
        $this->Attr = $attr;
    }
    
    public function Render($content = null) {
        return $this->RenderOpen() . HtmlGenerator::Render($content ? $content : $this->Content) . $this->RenderClose();
    }
    
    public function RenderOpen() {
        return '<' . $this->Name 
            . HtmlGenerator::EmitAttributes($this->Attr)
            . '>';
    }
    
    public function RenderClose() {
        return '</' . $this->Name . ">";
    }
    
    public function __toString() {
        return $this->Render();
    }
}
