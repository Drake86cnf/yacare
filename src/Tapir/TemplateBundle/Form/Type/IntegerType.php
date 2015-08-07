<?php
namespace Tapir\TemplateBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Campo de formulario para ingreso de números enteros.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */

class IntegerType extends AbstractType
{

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'maxlength' => 12,
            'attr' => array('class' => 'tapir-input-120', 'data-type' => 'cuilt', 'maxlength' => '12'))
            );
    }

    public function getParent()
    {
        return 'text';
    }

    public function getName()
    {
        return 'int';
    }
}