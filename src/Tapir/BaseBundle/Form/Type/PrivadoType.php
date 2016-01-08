<?php
namespace Tapir\BaseBundle\Form\Type;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Campo  de privacidad para un formulario determinado.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class PrivadoType extends ButtonGroupType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('choices' => array('Público' => 0, 'Privado' => 1)));
    }

    public function getParent()
    {
        return 'Tapir\BaseBundle\Form\Type\ButtonGroupType';
    }
}
