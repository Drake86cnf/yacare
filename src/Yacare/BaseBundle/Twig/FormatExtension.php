<?php
namespace Yacare\BaseBundle\Twig;

use Twig_Extension;
use Twig_Filter_Method;
use Twig_Function_Method;
use Symfony\Component\Form\Extension\Core\DataTransformer\DateTimeToStringTransformer;
use Symfony\Component\Form\Extension\Core\DataTransformer\DateTimeToTimestampTransformer;

class FormatExtension extends \Twig_Extension
{

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('yacare_verificacionnivel', array(
                $this,
                'yacare_verificacionnivel'
            )),
        );
    }


    public function yacare_verificacionnivel($verificacionNivel)
    {
    	return \Yacare\BaseBundle\Entity\Persona::VerificacionNivelNombre($verificacionNivel);
    }
    
    
    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'yacare_formatextension';
    }
}
