<?php
namespace Yacare\BaseBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PersonaType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('Apellido', null, array(
                'label' => 'Apellido'
            ))
            ->add('Nombre', null, array(
                'label' => 'Nombre'
            ))
            ->add('RazonSocial', null, array(
                'label' => 'Razón social'
            ))
            ->add('Documento', new \Yacare\BaseBundle\Form\Type\DocumentoType(), array(
                'label' => 'Documento'
            ))
            ->add('Cuilt', null, array(
                'label' => 'CUIL/CUIT'
            ))
            ->add('Grupos', 'entity', array(
                'label' => 'Grupos',
                'class' => 'YacareBaseBundle:PersonaGrupo',
                'multiple' => true,
                'required' => false
            ))
            ->add('UsuarioRoles', 'entity', array(
                'label' => 'Roles',
                'class' => 'TapirBaseBundle:PersonaRol',
                'multiple' => true,
                'required' => false
            ))
            ->add('Domicilio', new \Yacare\BaseBundle\Form\Type\DomicilioType(), array(
                'label' => 'Domicilio'
            ))
            ->add('TelefonoNumero', null, array(
                'label' => 'Teléfono(s)'
            ))
            ->add('Email', null, array(
                'label' => 'Correo electrónico'
            ))
            ->add('PersonaJuridica', 'checkbox', array(
                'label' => 'Persona jurídica',
                'required' => false
            ))
            ->add('FechaNacimiento', 'date', array(
                'years' => range(1900, 2099),
                'input' => 'datetime',
                'required' => false,
                'widget' => 'single_text',
                'attr' => array(
                    'class' => 'datepicker'
                ),
                'format' => 'dd/MM/yyyy',
                'label' => 'Fecha de nacimiento'
            ))
            ->add('Genero', 'choice', array(
                'choices' => array(
                    '0' => 'Sin especificar',
                    '1' => 'Masculino',
                    '2' => 'Femenino'
                ),
                'label' => 'Género',
                'required' => true
            ))
            ->add('Pais', 'entity', array(
                'label' => 'Nacionalidad',
                'placeholder' => 'Sin especificar',
                'class' => 'YacareBaseBundle:Pais',
                'required' => false
            ))
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
