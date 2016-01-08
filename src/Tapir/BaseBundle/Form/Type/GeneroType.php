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
                'Sin especificar' => 0, 
                'Masculino' => 1, 
                'Femenino' => 2, 
                'Otro' => 3)));
    }

    public function getParent()
    {
        return 'Tapir\BaseBundle\Form\Type\ButtonGroupType';
    }
}
