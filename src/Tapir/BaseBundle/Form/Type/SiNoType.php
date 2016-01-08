<?php
namespace Tapir\BaseBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Campo de formulario para selección de Sí/No.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class SiNoType extends ButtonGroupType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('choices' => array('No' => 0, 'Sí' => 1)));
    }

    public function getParent()
    {
        return 'Tapir\BaseBundle\Form\Type\ButtonGroupType';
    }
}
