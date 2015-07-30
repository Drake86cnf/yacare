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
        $resolver->setDefaults(
            array(
                'label' => 'Expediente',
                'maxlength' => 13,
                'attr' => array('class' => 'yacare-input-expediente',
                    'style' => 'max-width: 240px;',
                    'data-type' => 'yacare_expediente',
                    'maxlength' => '11')));
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