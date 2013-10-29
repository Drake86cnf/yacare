<?php

namespace Yacare\ComercioBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class LocalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Propietario', null, array(
                'label' => 'Propietario',
                'required'  => true
                ))
            ->add('Tipo', 'choice', array(
                'label' => 'Tipo',
                'required'  => true,
                'choices' => array(
                    'Local comercial' => 'Local comercial',
                    'Oficina comercial' => 'Oficina comercial',
                    'Galpón' => 'Galpón',
                    'Depósito' => 'Depósito',
                    'Otro' => 'Otro'
                    )
                ))
            ->add('Domicilio', new \Yacare\BaseBundle\Form\Type\DomicilioLocalType(), 
                    array(
                        'label' => 'Domicilio')
                    )
            ->add('Partida', 'integer', array(
                'label' => 'Partida Nº',
                'required'  => false
                ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yacare\ComercioBundle\Entity\Local'
        ));
    }

    public function getName()
    {
        return 'yacare_comerciobundle_localtype';
    }    
}
