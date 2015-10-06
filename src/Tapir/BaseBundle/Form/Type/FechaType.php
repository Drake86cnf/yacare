<?php
namespace Tapir\BaseBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Campo de formulario para ingreso de fechas.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class FechaType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'years' => range(1900, 2099),
                'maxlength' => 10,
                'attr' => array(
                    'placeholder' => 'día / mes / año',
                    'class' => 'tapir-input-160',
                    'data-type' => 'date',
                    'maxlength' => '10')));
    }

    public function getParent()
    {
        return 'date';
    }

    public function getName()
    {
        return 'fecha';
    }
}
