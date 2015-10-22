<?php
namespace Tapir\TemplateBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Campo de formulario para ingreso de números de punto flotante.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class FloatType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'maxlength' => 16, 
            'attr' => array('class' => 'tapir-input-160', 'maxlength' => '16')));
    }

    public function getParent()
    {
        return 'text';
    }

    public function getName()
    {
        return 'float';
    }
}
