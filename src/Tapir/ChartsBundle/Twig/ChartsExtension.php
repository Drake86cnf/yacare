<?php
namespace Tapir\ChartsBundle\Twig;

use Tapir\ChartsBundle\Charts\ChartInterface;

class ChartsExtension extends \Twig_Extension
{

    public function getFunctions()
    {
        return array(new \Twig_SimpleFunction('chart', array($this,'chart'), array('is_safe' => array('html'))));
    }

    public function chart(ChartInterface $chart, $engine = 'jquery')
    {
        return $chart->render($engine);
    }

    public function getName()
    {
        return 'charts_extension';
    }
}
