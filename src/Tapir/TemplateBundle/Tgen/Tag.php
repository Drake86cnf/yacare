<?php
namespace Tapir\TemplateBundle\Tgen;

/**
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class Tag
{
    public $Name, $Attr;
    
    public function __construct($name, $attr = null) {
        $this->Name = $name;
        $this->Attr = $attr;
    }
    
    public function EmitHtml($content = '') {
        return '<' . $this->Name 
            . HtmlGenerator::EmitAttributes($this->Attr)
            . '>'
            . $content
            . '</' . $this->Name . '>';
    }
}
