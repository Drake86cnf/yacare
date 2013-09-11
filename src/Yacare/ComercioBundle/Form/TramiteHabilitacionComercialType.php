<?php

namespace Yacare\ComercioBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TramiteHabilitacionComercialType extends \Yacare\TramitesBundle\Form\TramiteType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('Apoderado', 'entity', array(
                'label' => 'Apoderado',
                'class' => 'YacareBaseBundle:Persona',
                'required'  => false,
                'property' => 'Nombre',
                'multiple' => false,
                ))
            ->add('Local', 'entity', array(
                'label' => 'Local',
                'class' => 'YacareComercioBundle:Local',
                'required'  => true,
                'property' => 'Domicilio'
                ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yacare\ComercioBundle\Entity\TramiteHabilitacionComercial'
        ));
    }

    public function getName()
    {
        return 'yacare_tramitesbundle_tramitehabilitacioncomercialtype';
    }
}
