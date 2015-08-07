<?php
namespace Tapir\BaseBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Campo de formulario para ingreso de superficie en metros cuadrados (enteros).
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */

class SuperficieType extends \Tapir\TemplateBundle\Form\Type\IntegerType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'maxlength' => 6,
            'attr' => array('class' => 'tapir-input-120', 'data-type' => 'number', 'maxlength' => '6', 'suffix' => 'm²')));
    }

    public function getParent()
    {
        return 'text';
    }

    public function getName()
    {
        return 'superficie';
    }
}