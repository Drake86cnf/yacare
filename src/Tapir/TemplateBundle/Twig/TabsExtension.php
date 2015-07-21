<?php
namespace Tapir\TemplateBundle\Twig;

class TabsExtension extends \Twig_Extension
{

    public function getFunctions()
    {
        return array(new \Twig_SimpleFunction('tabset', array($this,'tabset'), array('is_safe' => array('html'))));
    }

    public function tabset(\Tapir\TemplateBundle\Tabs\TabSet $tabs)
    {
        return $tabs->render();
    }

    public function getName()
    {
        return 'tabs_extension';
    }
}
