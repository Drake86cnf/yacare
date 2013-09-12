<?php

namespace Yacare\BaseBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PersonaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Apellido', null, array('label' => 'Apellido'))
            ->add('Nombre', null, array('label' => 'Nombre'))
            ->add('RazonSocial', null, array('label' => 'Razón social'))
            ->add('Documento', new \Yacare\BaseBundle\Form\DocumentoType(), array('label' => 'Documento'))
            ->add('Grupos', 'entity', array(
                'label' => 'Grupos',
                'class' => 'YacareBaseBundle:PersonaGrupo',
                'property' => 'Nombre',
                'multiple' => true,
                ))
            ->add('Domicilio', new \Yacare\BaseBundle\Form\DomicilioType(), array('label' => 'Domicilio'))
            ->add('TelefonoNumero', null, array('label' => 'Número de teléfono'))
            ->add('Email', null, array('label' => 'Correo electrónico'))
            ->add('PersonaJuridica', 'checkbox', array(
                'label' => 'Persona jurídica',
                'required' => false,))
            ->add('FechaNacimiento', 'date', array(
                'years' => range(1900,2099),
                'input' => 'datetime',
                'widget' => 'single_text',
                'attr' => array('class' => 'datepicker'),
                'format' => 'dd/MM/yyyy',
                'label' => 'Fecha de nacimiento'))
            ->add('Genero', 'choice', array(
                'choices' => array('0' => 'Masculino', '1' => 'Femenino'),
                'label' => 'Género',
                'empty_value' => 'Sin especificar',
            ))
            ->add('Pais', 'entity', array(
                'label' => 'Nacionalidad',
                'empty_value' => 'Sin especificar',
                'class' => 'YacareBaseBundle:Pais',
                'required' => false,
                'empty_value' => false,
                'property' => 'Nombre'))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yacare\BaseBundle\Entity\Persona'
        ));
    }

    public function getName()
    {
        return 'yacare_basebundle_personatype';
    }
}
