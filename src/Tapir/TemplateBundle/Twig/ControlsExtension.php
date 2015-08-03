<?php
namespace Tapir\TemplateBundle\Twig;

class ControlsExtension extends \Twig_Extension
{

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('bs_button', array($this,'bs_button'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('bs_tabset', array($this,'bs_tabset'), array('is_safe' => array('html')))
        );
    }
    
    
    public function bs_button($label, $url, $attr) {
        return '<button href="' . $url . '" class="btn btn-default">' . $label . '</button>';        
    }

    
    public function bs_tabset(\Tapir\TemplateBundle\Controls\TabSet $tabs)
    {
        return $tabs->render();
    }

    
    public function getName()
    {
        return 'controls_extension';
    }
}
