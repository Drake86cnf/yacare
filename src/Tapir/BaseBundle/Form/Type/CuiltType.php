<?php
namespace Tapir\BaseBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CuiltType extends AbstractType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'label' => 'CUIL/CUIT',
            'maxlength' => 13,
            'attr' => array ( 'class' => 'input-cuilt', 'maxlength' => '13' )
        ));
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