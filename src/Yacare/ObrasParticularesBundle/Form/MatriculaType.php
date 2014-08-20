<?php

namespace Yacare\ObrasParticularesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MatriculaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', null, array('label' => 'Legajo', 'read_only' => true))
            ->add('Nombre', null, array('label' => 'Nombre', 'required' => true))
            ->add('Email', null, array('label' => 'Email', 'required' => false))
            ->add('Estado', 'choice', array(
                 'label' => 'Estado',
                 'required'  => true,
                 'choices' => array(
                    0 => 'No habilitado',
                    1 => 'Habilitado',
                    
                    )
                 ))
            ->add('Profesion', 'choice', array(
                'label' => 'Profesion',
                'required'  => true,
                'choices' => array(
                    0 => 'Ingeniero civil',
                    1 => 'Arquitecto',
                    91 => 'Maestro mayor de obras',
                    100 => 'Tecnico en construcciones'
                    )
                ))
            ->add('FechaVencimiento', 'date', array(
                'years' => range(1900, 2099),
                'input' => 'datetime',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'label' => 'Fecha de ingreso'))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yacare\ObrasParticularesBundle\Entity\Matricula'
        ));
    }

    public function getName()
    {
        return 'yacare_obrasparticularesbundle_matriculatype';
    }
}   
