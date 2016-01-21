<?php
namespace Tapir\TemplateBundle\Twig;

use Tapir\TemplateBundle\Tgen\HtmlGenerator;
class TgenExtension extends \Twig_Extension
{
    protected $Tgen;
    
    public function getGlobals()
    {
        return array(
            'tgen' => $this->getTgen(),
        );
    }
    
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('tgnew', array($this, 'tgnew'), array('is_safe' => array('all'), 'is_variadic' => true)),
            new \Twig_SimpleFunction('tg', array($this, 'tg'), array('is_safe' => array('all'), 'is_variadic' => true)),
        );
    }

    public function tgnew($method, array $args = array())
    {
        return call_user_func_array(array($this->getTgen(), $method), $args);
    }
    
    public function tg($content, array $args = array())
    {
        return HtmlGenerator::Render($content);
    }
    
    public function getName()
    {
        return 'tgen_extension';
    }

    public function getTgen()
    {
        if(!$this->Tgen) {
            // TODO: que se pueda configurar el generador
            $this->Tgen = new \Tapir\TemplateBundle\Tgen\Bootstrap3Generator();
        }
        return $this->Tgen;
    }
 
}
