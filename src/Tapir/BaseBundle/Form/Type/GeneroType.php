<?php
namespace Tapir\BaseBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Campo de formulario para selección de género.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class GeneroType extends ButtonGroupType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'choices' => array(
                '0' => 'Sin especificar', 
                '1' => 'Masculino', 
                '2' => 'Femenino', 
                '3' => 'Otro')));
    }

    public function getParent()
    {
        return 'buttongroup';
    }

    public function getName()
    {
        return 'genero';
    }
}
