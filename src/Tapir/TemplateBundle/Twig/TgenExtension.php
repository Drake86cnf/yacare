<?php
namespace Tapir\TemplateBundle\Twig;

class TgenExtension extends \Twig_Extension
{
    protected $Tgen;
    
    public function getGlobals()
    {
        return array(
            'tgen' => $this->getTgent(),
        );
    }
    
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('tg', array($this, 'tg'), array('is_safe' => array('all'), 'is_variadic' => true)),
            new \Twig_SimpleFunction('tg.Progress', array($this, 'tg'), array('is_safe' => array('all'), 'is_variadic' => true)),
        );
    }

    public function tg($method, array $args = array())
    {
        return call_user_func_array(array($this->getTgent(), $method), $args);
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
