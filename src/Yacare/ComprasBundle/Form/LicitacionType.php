<?php

namespace Yacare\ComprasBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class LicitacionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Departamento', 'entity', array(
                'label' => 'Departamento',
                'empty_value' => 'Sin especificar',
                'class' => 'YacareOrganizacionBundle:Departamento',
                'required' => false,
                'empty_value' => false,
                'property' => 'Nombre'))
            ->add('Numero', null, array('label' => 'Número'))
            ->add('Nombre', null, array('label' => 'Nombre'))
            ->add('Importe', null, array('label' => 'Importe'))
            ->add('Complejidad1', 'choice', array(
                'label' => 'Complejidad 1',
                'required'  => true,
                'choices' => array('0' => 'Baja', '1' => 'Media', '2' => 'Alta')
                ))
            ->add('Complejidad2', 'choice', array(
                'label' => 'Complejidad 2',
                'required'  => true,
                'choices' => array('0' => 'Baja', '1' => 'Media', '2' => 'Alta')
                ))
            ->add('Complejidad3', 'choice', array(
                'label' => 'Complejidad 3',
                'required'  => true,
                'choices' => array('0' => 'Baja', '1' => 'Media', '2' => 'Alta')
                ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yacare\ComprasBundle\Entity\Licitacion'
        ));
    }

    public function getName()
    {
        return 'yacare_comprasbundle_licitaciontype';
    }
}
