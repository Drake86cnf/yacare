<?php
namespace Tapir\BaseBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Campo  de privacidad para un formulario determinado.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class PrivadoType extends ButtonGroupType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('choices' => array('0' => 'Público', '1' => 'Privado')));
    }

    public function getParent()
    {
        return 'buttongroup';
    }

    public function getName()
    {
        return 'privado';
    }
}
