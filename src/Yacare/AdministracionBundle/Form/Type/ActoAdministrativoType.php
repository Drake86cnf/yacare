<?php
namespace Yacare\AdministracionBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Campo de formulario para ingreso de número de acto administrativo.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class ActoAdministrativoType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'label' => 'Acto admin.', 
            'maxlength' => 13, 
            'attr' => array(
                'class' => 'yacare-input-acad', 
                'class' => 'tapir-input-240', 
                'data-type' => 'yacare_acad', 
                'maxlength' => '11')));
    }

    public function getParent()
    {
        return 'text';
    }

    public function getName()
    {
        return 'yacare_acad';
    }
}
