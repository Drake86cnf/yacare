<?php
namespace Tapir\BaseBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Campo de formulario para ingreso de fecha y hora.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class FechaHoraType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'date_widget' => 'single_text',
                'time_widget' => 'single_text',
                'date_format' => 'dd/MM/yyyy',
                'time_format' => 'H:i',
                'years' => range(1900, 2099),
                'with_seconds' => false,
                'placeholder' => 'placeholder1',
                'html5' => true,
                'attr' => array(
                    'placeholder' => 'día / mes / año',
                    'class' => 'form-inline tapir-input-sinespacios tapir-input-fechahora')));
    }

    public function getParent()
    {
        return 'Symfony\Component\Form\Extension\Core\Type\DateTimeType';
    }
}
