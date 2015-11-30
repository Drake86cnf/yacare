<?php
namespace Yacare\AdministracionBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Campo de formulario para ingreso de número de expediente.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class ExpedienteType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'label' => 'Expediente', 
            'maxlength' => 13, 
            'attr' => array(
                'class' => 'tapir-input-240 yacare-input-expediente tapir-input-mayus tapir-input-sinespacios yacare-input-expediente', 
                'data-type' => 'yacare_expediente', 
                'maxlength' => '13')));
    }

    public function getParent()
    {
        return 'text';
    }

    public function getName()
    {
        return 'yacare_expediente';
    }
}
