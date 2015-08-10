<?php
namespace Tapir\TemplateBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Campo de formulario para ingreso de fechas.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */

class DateType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'maxlength' => 10,
            'attr' => array('class' => 'tapir-input-120', 'data-type' => 'date', 'maxlength' => '10'))
            );
    }

    public function getParent()
    {
        return 'date';
    }

    public function getName()
    {
        return 'date';
    }
}