<?php

namespace Yacare\BaseBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DomicilioLocalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('DomicilioCalle', null, array('label' => 'Calle'))
            ->add('DomicilioNumero', null, array('label' => 'Número'))
            ->add('DomicilioPiso', null, array('label' => 'Piso'))
            ->add('DomicilioPuerta', null, array('label' => 'Puerta'))
            ->setAttribute('widget', 'domicilio')
        ;
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'inherit_data' => true
        ));
    }

    public function getName()
    {
        return 'yacare_basebundle_domiciliolocaltype';
    }
}
