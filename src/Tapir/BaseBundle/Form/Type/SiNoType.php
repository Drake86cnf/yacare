<?php
namespace Tapir\BaseBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SiNoType extends ButtonGroupType
{

    public function setDefaultOptions(OptionsResolverInterface $resolver)
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