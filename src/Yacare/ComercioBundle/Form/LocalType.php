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
            ->add('Partida', 'entity_id', array(
                'label' => 'Partida',
                'class' => 'Yacare\CatastroBundle\Entity\Partida',
                'required' => true))
            ->add('Tipo', 'choice', array(
                'label' => 'Tipo',
                'required'  => true,
                'choices' => array(
                    'Local de ventas' => 'Local de ventas',
                    'Oficina' => 'Oficina',
                    'Galpón' => 'Galpón',
                    'Depósito' => 'Depósito',
                    'Otro' => 'Otro'
                    )
                ))
            ->add('DepositoClase', 'entity', array(
                'label' => 'Tipo de depósito',
                'empty_value' => '(sólo para depósitos)',
                'class' => 'Yacare\ComercioBundle\Entity\DepositoClase',
                'required' => false))
            ->add('Superficie', null, array(
                'label' => 'Superficie (m²)'))
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
