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
                'label' => 'Partida Nº',
                'class' => 'Yacare\CatastroBundle\Entity\Partida',
                'required' => false))
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
            ->add('Propietario', 'entity_id', array(
                'label' => 'Propietario',
                'property' => 'NombreVisible',
                'class' => 'Yacare\BaseBundle\Entity\Persona',
                'required' => true))
            ->add('Domicilio', new \Yacare\BaseBundle\Form\Type\DomicilioLocalType(), 
                    array(
                        'label' => 'Domicilio')
                    )
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
