<?php

namespace Yacare\InspeccionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RelevamientoAsignacionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Relevamiento', 'entity', array(
                'label' => 'Relevamiento',
                'class' => 'YacareInspeccionBundle:Relevamiento',
                'required' => true,
                'empty_value' => false,
                'property' => 'Nombre'))
            ->add('Encargado', 'entity', array(
                'label' => 'Encargado',
                'class' => 'YacareRecursosHumanosBundle:Agente',
                'required' => true,
                'empty_value' => false,
                'property' => 'Persona.NombreVisible'))
            ->add('Calle', 'entity', array(
                'label' => 'Calle',
                'class' => 'YacareCatastroBundle:Calle',
                'required' => true,
                'empty_value' => false,
                'property' => 'Nombre'))
            ->add('Seccion', null, array('label' => 'Sección'))
            ->add('Macizo', null, array('label' => 'Macizo'))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yacare\InspeccionBundle\Entity\RelevamientoAsignacion'
        ));
    }

    public function getName()
    {
        return 'yacare_inspeccionbundle_relevamientoasignaciontype';
    }
}
