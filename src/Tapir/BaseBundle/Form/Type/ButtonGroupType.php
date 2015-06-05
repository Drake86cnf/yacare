<?php
namespace Tapir\BaseBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

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