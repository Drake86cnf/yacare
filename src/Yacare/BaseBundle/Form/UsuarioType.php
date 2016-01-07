<?php
namespace Yacare\BaseBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Formulario para usuarios.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class UsuarioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('NombreVisible', null, array('label' => 'Nombre'))
            ->add('Email', 'Symfony\Component\Form\Extension\Core\Type\EmailType', array(
                'label' => 'Correo electrónico', 
                'attr' => array('autocomplete' => 'off', 'readonly' => true, 'class' => 'tapir-input-minus')))
            ->add('UsuarioRoles', 'Symfony\Bridge\Doctrine\Form\Type\EntityType', array(
                'label' => 'Roles', 
                'class' => 'YacareBaseBundle:PersonaRol', 
                'choice_label' => 'Nombre', 
                'multiple' => true))
            ->add('Username', null, array(
                'label' => 'Usuario', 
                'required' => false, 
                'attr' => array('autocomplete' => 'off', 'class' => 'tapir-input-minus')))
            ->add('PasswordEnc', 'Symfony\Component\Form\Extension\Core\Type\PasswordType', array(
                'label' => 'Contraseña', 
                'required' => false, 
                'attr' => array('autocomplete' => 'off')));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'Yacare\BaseBundle\Entity\Persona'));
    }
}
