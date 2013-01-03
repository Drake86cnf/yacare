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
            ->add('Apellido', null, array('label' => 'Apellido',))
            ->add('Nombre', null, array('label' => 'Nombre',))
            ->add('RazonSocial', null, array('label' => 'Razón Social',))
            ->add('TipoDocumento', 'choice', array(
                'choices'  => array(
                    '0'  => 'DNI',
                    '1'   => 'CI',
                    '2' => 'CUIL',
                    '3' => 'CUIT',
                    ),
                'label' => 'Tipo de Documento',))
            ->add('NumeroDocumento', null, array('label' => 'Número de Documento',))
            ->add('Calle', null, array('label' => 'Calle',))
            ->add('NumeroCalle', null, array('label' => 'Número',))
            ->add('Piso', null, array('label' => 'Piso',))
            ->add('Puerta', null, array('label' => 'Puerta',))
            ->add('NumeroTelefono', null, array('label' => 'Número de Teléfono',))
            ->add('Email', null, array('label' => 'e-mail',))
            ->add('PersonaJuridica', null, array('label' => 'Persona Jurídica',))
            ->add('CodigoPostal', null, array('label' => 'Código Postal',))
            ->add('FechaNacimiento', 'date', array(
                'years' => range(1900,2013),
                'input' => 'datetime',
                'widget' => 'choice',
                'format' => 'dd-MM-yyyy',
                'label' => 'Fecha de Nacimiento',))
            ->add('Genero', 'choice', array(
                'choices' => array('0' => 'Masculino', '1' => 'Femenino'),
                'label' => 'Género',
            ))
            ->add('Nacionalidad', 'entity', array('label' => 'Nacionalidad',
                'class' => 'YacareBaseBundle:Pais',
                'required' => true,
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
