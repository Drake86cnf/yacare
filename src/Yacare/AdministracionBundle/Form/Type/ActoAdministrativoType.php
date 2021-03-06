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
            'placeholder' => 'XX-1234/' . date('Y'),
            'attr' => array(
                'class' => 'yacare-input-acad tapir-input-240 tapir-input-mayus tapir-input-sinespacios yacare-input-acad',
                'data-type' => 'yacare_acad', 
                'maxlength' => '13')));
    }

    public function getParent()
    {
        return 'Symfony\Component\Form\Extension\Core\Type\TextType';
    }
}
