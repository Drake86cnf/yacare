<?php
namespace Tapir\BaseBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SiNoType extends ButtonGroupType
{

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'choices' => array('0' => 'No', '1' => 'Sí')));
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