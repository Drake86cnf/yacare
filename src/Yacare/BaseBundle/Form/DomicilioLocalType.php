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
            ->add('DomicilioCalle', 'entity', array(
                'label' => 'Calle',
                'class' => 'YacareCatastroBundle:Calle',
                'required'  => true,
                'property' => 'Nombre'
                ))
            ->add('DomicilioNumero', null, array(
                'label' => 'Nº',
                'required' => false
                ))
            ->add('DomicilioPiso', null, array(
                'label' => 'Piso',
                'required' => false
                ))
            ->add('DomicilioPuerta', null, array(
                'label' => 'Puerta',
                'required' => false
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
