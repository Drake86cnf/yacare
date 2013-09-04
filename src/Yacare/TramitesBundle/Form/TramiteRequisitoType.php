<?php

namespace Yacare\TramitesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TramiteRequisitoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            /* ->add('Tipo', 'choice', array(
                'label' => 'Tipo',
                'required'  => true,
                'choices' => array('cond' => 'Condición', 
                    'ext' => 'Externo',
                    'tra' => 'Trámite',
                    'compy' => 'Compuesto Y',
                    'compo' => 'Compuesto O'
                    )
                )) */
            ->add('Tramite', 'entity', array(
                'label' => 'Tramite',
                'class' => 'YacareTramitesBundle:Tramite',
                'required' => true,
                'property' => 'Nombre',
                'multiple' => false,
                'read_only' => true,
                ))
            ->add('Propiedad', 'choice', array(
                'label' => 'Propiedad',
                'required'  => false,
                'empty_value' => 'n/a',
                'choices' => array(
                    'Titular' => 'Titular', 
                    'Apoderado' => 'Apoderado', 
                    'Inmueble' => 'Inmueble', 
                    'Inmueble.Titular' => 'Titular del inmueble', 
                    'ReponsableTecnico' => 'Reponsable técnico', 
                    )
                ))
            ->add('Opcional', 'checkbox', array(
                'label' => 'Opcional',
                'required'  => false,
                ))
            ->add('Requisito', 'entity', array(
                'label' => 'Requisito',
                'class' => 'YacareTramitesBundle:Requisito',
                'required'  => true,
                'property' => 'Nombre',
                'multiple' => false,
                ))
            ->add('CondicionQue', 'text', array(
                'label' => 'Sólo si',
                'required'  => false,
                ))
            ->add('CondicionEs', 'choice', array(
                'label' => 'Es',
                'required'  => false,
                'empty_value' => 'n/a',
                'choices' => array(
                    '==' => 'igual', 
                    '>' => 'mayor', 
                    '<' => 'menor', 
                    '!=' => 'diferente', 
                    '>=' => 'mayor o igual', 
                    '<=' => 'menor o igual', 
                    'notnull' => 'existe',
                    'null' => 'no existe',
                    'true' => 'verdadero',
                    'false' => 'falso'
                    )
                ))
            ->add('CondicionCuanto', 'text', array(
                'label' => 'A',
                'required'  => false,
                ))
            ->add('Obs', null, array(
                'label' => 'Obs.',
                
                )
        );
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yacare\TramitesBundle\Entity\TramiteRequisito'
        ));
    }

    public function getName()
    {
        return 'yacare_tramitesbundle_tramiterequisitoype';
    }
}
