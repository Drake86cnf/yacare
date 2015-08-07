<?php
namespace Tapir\TemplateBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Campo de formulario para ingreso de direcciones de correo electrónico.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */

class EmailType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'maxlength' => 200,
            'attr' => array('class' => 'tapir-input-480', 'data-type' => 'email', 'type' => 'email', 'maxlength' => '200'))
            );
    }

    public function getParent()
    {
        return 'text';
    }

    public function getName()
    {
        return 'email';
    }
}