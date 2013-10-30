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
            ->add('Propietario', 'entity_id', array(
                'label' => 'En poder de',
                'property' => 'NombreVisible',
                'class' => 'Yacare\BaseBundle\Entity\Persona',
                'required' => true))
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
            ->add('Partida', 'entity_id', array(
                'label' => 'Partida Nº',
                'class' => 'Yacare\CatastroBundle\Entity\Partida',
                'required' => false))
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
