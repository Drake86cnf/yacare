<?php

namespace Yacare\BaseBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DomicilioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('DomicilioCalle', null, array(
                'label' => '',
                'required'  => true
                ))
            ->add('DomicilioNumero', null, array(
                'label' => 'Nº'
                ))
            ->add('DomicilioPiso', null, array(
                'label' => 'Piso'
                ))
            ->add('DomicilioPuerta', null, array(
                'label' => 'Puerta'
                ))
            ->setAttribute('widget', 'form_horizontal')
        ;
    }
    
        public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'inherit_data' => true,
            'class' => 'form_horizontal'
        ));
    }

    public function getName()
    {
        return 'form_horizontal';
    }
}
