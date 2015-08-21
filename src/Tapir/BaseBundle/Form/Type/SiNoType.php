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
        $resolver->setDefaults(array('choices' => array('0' => 'No', '1' => 'Sí')));
    }

    public function getParent()
    {
        return 'buttongroup';
    }

    public function getName()
    {
        return 'sino';
    }
}
