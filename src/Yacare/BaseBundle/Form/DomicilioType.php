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
            ->add('DomicilioCalle', null, array('label' => 'Calle'))
            ->add('DomicilioNumero', null, array('label' => 'Número'))
            ->add('DomicilioPiso', null, array('label' => 'Piso'))
            ->add('DomicilioPuerta', null, array('label' => 'Puerta'))
            ->add('DomicilioCodigoPostal', null, array('label' => 'Código postal'))
        ;
    }

    public function getName()
    {
        return 'yacare_basebundle_domiciliotype';
    }
}
