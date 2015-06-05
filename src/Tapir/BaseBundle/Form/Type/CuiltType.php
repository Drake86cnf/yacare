<?php
namespace Tapir\BaseBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CuiltType extends AbstractType
{

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'label' => 'CUIL/CUIT',
                'maxlength' => 13,
                'attr' => array('class' => 'tapir-input-cuilt','data-type' => 'cuilt','maxlength' => '13')));
    }

    public function getParent()
    {
        return 'text';
    }

    public function getName()
    {
        return 'cuilt';
    }
}