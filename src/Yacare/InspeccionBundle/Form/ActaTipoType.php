<?php

namespace Yacare\InspeccionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ActaTipoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Nombre', null, array('label' => 'Nombre'))
            ->add('Departamento', 'entity', array(
                'label' => 'Departamento',
                'empty_value' => 'Sin especificar',
                'class' => 'YacareOrganizacionBundle:Departamento',
                'required' => false,
                'empty_value' => false,
                'property' => 'Nombre'))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yacare\InspeccionBundle\Entity\ActaTipo'
        ));
    }

    public function getName()
    {
        return 'yacare_inspeccionbundle_actatipotype';
    }
}