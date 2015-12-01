<?php
namespace Yacare\BaseBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Formulario para crear una contraseña, para un usuario.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class PersonaCrearContrasenaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('PasswordEnc', 'password', array(
                'label' => 'Contraseña nueva',
                'attr' => array('autocomplete' => 'off', 'class' => 'tapir-input-240'),
                'required' => true))
            ->add('PasswordEnc2', 'password', array(
                'label' => 'Repetir contraseña',
                'attr' => array('autocomplete' => 'off', 'class' => 'tapir-input-240'),
                'required' => true, 
                'mapped' => false));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'Yacare\BaseBundle\Entity\Persona'));
    }
}
