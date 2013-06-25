<?php

namespace Yacare\BaseBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UsuarioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('NombreVisible', null, array('label' => 'Nombre', 'read_only' => true))
            ->add('Email', null, array('label' => 'Correo electrónico'))
            ->add('Roles', 'entity', array(
                'label' => 'Roles',
                'class' => 'YacareBaseBundle:PersonaRol',
                'property' => 'Nombre',
                'multiple' => true,
                ))
            ->add('Username', null, array('label' => 'Usuario', 'required' => false))
            ->add('PasswordEnc', 'password', array('label' => 'Contraseña', 'required' => false))
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
        return 'yacare_basebundle_usuariotype';
    }
}
