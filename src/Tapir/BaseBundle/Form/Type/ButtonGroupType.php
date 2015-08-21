<?php
namespace Tapir\BaseBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Campo de formulario para selección de una opción dentro de un conjunto reducido.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class ButtonGroupType extends AbstractType
{
    public function getParent()
    {
        return 'choice';
    }

    public function getName()
    {
        return 'buttongroup';
    }
}
