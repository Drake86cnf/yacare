<?php

namespace Yacare\BromatologiaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProtocoloType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder            
            ->add('ProtocoloNumero', null, array('label' => 'Protocolo Nº'))
            ->add('Persona', null, array('label' => 'Persona'))
            ->add('Producto', null, array('label' => 'Producto'))
            ->add('Envase', null, array('label' => 'Envase'))
            ->add('FechaElaboracion', 'date', array(
                'years' => range(1900,2099),
                'input' => 'datetime',
                'widget' => 'single_text',
                'attr' => array('class' => 'datepicker'),
                'format' => 'dd/MM/yyyy',
                'label' => 'Fecha de elaboración'))
            ->add('FechaVencimiento', 'date', array(
                'years' => range(1900,2099),
                'input' => 'datetime',
                'widget' => 'single_text',
                'attr' => array('class' => 'datepicker'),
                'format' => 'dd/MM/yyyy',
                'label' => 'Fecha de vencimiento'))
            ->add('ActaNumero', null, array('label' => 'Acta Nº'))
            ->add('FechaRecepcion', 'date', array(
                'years' => range(1900,2099),
                'input' => 'datetime',
                'widget' => 'single_text',
                'attr' => array('class' => 'datepicker'),
                'format' => 'dd/MM/yyyy',
                'label' => 'Fecha de recepciomn'))
            ->add('Analisis', null, array('label' => 'Análisis'))           
            ->add('Resultado', 'choice', array(
                'choices'   => array(
                    '1' => 'Apto',
                    '2' => 'No Apto',
                    ),
                'required'  => true,
                'label' => 'Resultado'))
            ->add('Observaciones', null, array('label' => 'Observaciones'))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yacare\BromatologiaBundle\Entity\Protocolo'
        ));
    }

    public function getName()
    {
        return 'yacare_bromatologiabundle_protocolo';
    }
}
