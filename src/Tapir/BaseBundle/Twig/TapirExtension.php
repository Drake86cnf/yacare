<?php
namespace Tapir\BaseBundle\Twig;

use Twig_Extension;
use Twig_Filter_Method;
use Twig_Function_Method;
use Symfony\Component\Form\Extension\Core\DataTransformer\DateTimeToStringTransformer;
use Symfony\Component\Form\Extension\Core\DataTransformer\DateTimeToTimestampTransformer;

class TapirExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('tapir_escuiltvalido', array(
                $this,
                'tapir_escuiltvalido'
            )),
            new \Twig_SimpleFilter('tapir_cantidaddedias', array(
                $this,
                'tapir_cantidaddedias'
            )),
            new \Twig_SimpleFilter('tapir_sino', array(
                $this,
                'tapir_sino'
            )),
            new \Twig_SimpleFilter('tapir_fecha', array(
                $this,
                'tapir_fecha'
            )),
            new \Twig_SimpleFilter('tapir_importe', array(
                $this,
                'tapir_importe'
            )),
        	new \Twig_SimpleFilter('tapir_porcentaje', array(
        			$this,
        			'tapir_porcentaje'
        	))
        );
    }


    public function tapir_escuiltvalido($Cuilt)
    {
    	return true;
    }
    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'tapir_extension';
    }
}
