<?php

namespace Yacare\TramitesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TramiteTipoRequisitoType extends AbstractType
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
            ->add('TramiteTipo', 'entity', array(
                'label' => 'Tipo de trámite',
                'class' => 'YacareTramitesBundle:TramiteTipo',
                'required' => true,
                'property' => 'Nombre',
                'multiple' => false,
                'read_only' => true,
                ))
            ->add('Requisito', 'entity', array(
                'label' => 'Requisito',
                'class' => 'YacareTramitesBundle:Requisito',
                'required'  => true,
                'property' => 'Nombre',
                'multiple' => false,
                ))
            ->add('Propiedad', 'choice', array(
                'label' => 'De',
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
            'data_class' => 'Yacare\TramitesBundle\Entity\TramiteTipoRequisito'
        ));
    }

    public function getName()
    {
        return 'yacare_tramitesbundle_tramitetiporequisitoype';
    }
}
