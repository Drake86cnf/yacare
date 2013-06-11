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
            ->add('DocumentoTipo', 'choice', array(
                'choices'  => array(
                    '1'  => 'DNI',
                    '2'   => 'LE',
                    '3'   => 'LC',
                    '4'   => 'CI',
                    '98' => 'CUIL',
                    '99' => 'CUIT',
                    ),
                'label' => 'Tipo de documento'))
            ->add('DocumentoNumero', null, array('label' => 'Número de documento'))
            ->add('Grupos', 'entity', array(
                'label' => 'Grupos',
                'class' => 'YacareBaseBundle:PersonaGrupo',
                'property' => 'Nombre',
                'multiple' => true,
                ))
            ->add('UsuarioNombre', null, array('label' => 'Nombre de usuario'))
            ->add('DomicilioCalle', null, array('label' => 'Calle'))
            ->add('DomicilioNumero', null, array('label' => 'Número'))
            ->add('DomicilioPiso', null, array('label' => 'Piso'))
            ->add('DomicilioPuerta', null, array('label' => 'Puerta'))
            ->add('DomicilioCodigoPostal', null, array('label' => 'Código postal'))
            ->add('TelefonoNumero', null, array('label' => 'Número de teléfono'))
            ->add('Email', null, array('label' => 'Correo electrónico   '))
            ->add('PersonaJuridica', 'checkbox', array(
                'label' => 'Persona jurídica',
                'required' => false,))
            ->add('FechaNacimiento', 'date', array(
                'years' => range(1900,2099),
                'input' => 'datetime',
                'widget' => 'single_text',
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
