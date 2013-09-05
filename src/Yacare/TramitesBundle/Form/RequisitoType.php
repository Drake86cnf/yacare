<?php

namespace Yacare\TramitesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RequisitoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Nombre', null, array('label' => 'Nombre'))
            ->add('Lugar', null, array(
                'label' => 'Lugar',
                'attr'  => array('placeholder' => 'Lugar físico donde se obtiene o tramita')
                ))
            ->add('Url', null, array(
                'label' => 'Web',
                'attr'  => array('placeholder' => 'Sitio web con información')
                ))
            ->add('Tipo', 'choice', array(
                'label' => 'Tipo',
                'required'  => true,
                'choices' => array('cond' => 'Condición', 
                    'ext' => 'Externo',
                    'int' => 'Interno',
                    'tra' => 'Trámite',
                    'compy' => 'Compuesto Y',
                    'compo' => 'Compuesto O'
                    )
                ))
            ->add('Requiere', 'entity', array(
                'label' => 'Sub-requisitos',
                'class' => 'YacareTramitesBundle:Requisito',
                'required'  => false,
                'property' => 'Nombre',
                'multiple' => true,
                ))
            ->add('Instancia', 'choice', array(
                'label' => 'Instancia',
                'required'  => true,
                'choices' => array('na' => 'n/a', 
                    'ori' => 'Original',
                    'cop' => 'Copia'
                    )
                ))
            ->add('Obs', null, array(
                'label' => 'Obs.',
                ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yacare\TramitesBundle\Entity\Requisito'
        ));
    }

    public function getName()
    {
        return 'yacare_tramitesbundle_requisitoype';
    }
}
