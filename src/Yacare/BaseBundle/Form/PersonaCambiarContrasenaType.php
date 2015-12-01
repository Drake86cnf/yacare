<?php
namespace Yacare\BaseBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

/**
 * Formulario para cambiar la contraseña de un usuario.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class PersonaCambiarContrasenaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ContrasenaActual', 'password', array(
                'label' => 'Contraseña actual',
                'attr' => array('autocomplete' => 'off', 'class' => 'tapir-input-240'),
                'required' => true,
                'constraints' => new UserPassword(),
                'mapped' => false))
            ->add('PasswordEnc', 'password', array(
                'label' => 'Contraseña nueva',
                'attr' => array('autocomplete' => 'off', 'class' => 'tapir-input-240'),
                'required' => true))
            ->add('PasswordEnc2', 'password', array(
                'label' => 'Confirmar contraseña nueva',
                'attr' => array('autocomplete' => 'off', 'class' => 'tapir-input-240'),
                'required' => true, 
                'mapped' => false));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'Yacare\BaseBundle\Entity\Persona'));
    }
}
