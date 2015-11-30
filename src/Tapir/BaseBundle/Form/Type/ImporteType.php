<?php
namespace Tapir\BaseBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Campo de formulario para ingreso de importes monetarios.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class ImporteType extends \Tapir\TemplateBundle\Form\Type\IntegerType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'maxlength' => 6,
                'attr' => array(
                    'class' => 'tapir-input-160 tapir-input-sinespacios',
                    'data-type' => 'number',
                    'maxlength' => '16',
                    'prefix' => '$')));
    }

    public function getParent()
    {
        return 'text';
    }

    public function getName()
    {
        return 'importe';
    }
}
