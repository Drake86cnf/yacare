<?php
namespace Tapir\TemplateBundle\Tgen;

/**
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class Content
{
    public $Content;
    
    public function __construct(...$content) {
        $this->Content = $content;
    }
    
    public function Render($content = null) {
        $res = '';
        foreach($this->Content as $content) {
            $res .= (string)$content;
        }
        
        return $res;
    }
    
    public function __toString() {
        return $this->Render();
    }
}
