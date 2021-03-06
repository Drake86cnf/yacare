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
            ->add('PasswordEnc', 'Symfony\Component\Form\Extension\Core\Type\PasswordType', array(
                'label' => 'Contraseña nueva',
                'attr' => array('autocomplete' => 'off', 'class' => 'tapir-input-240'),
                'required' => true));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'Yacare\BaseBundle\Entity\Persona'));
    }
}
