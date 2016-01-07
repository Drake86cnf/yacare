<?php
namespace Yacare\BaseBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Formulario para crear un perfil de usuario.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class PersonaPerfilCrearType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Username', null, array(
                'label' => 'Nombre de usuario',
                'attr' => array('autocomplete' => 'off', 'class' => 'tapir-input-minus tapir-input-240'),
                'required' => false))
            ->add('PasswordEnc', 'Symfony\Component\Form\Extension\Core\Type\PasswordType', array(
                'label' => 'Contraseña',
                'attr' => array('autocomplete' => 'off', 'class' => 'tapir-input-240'),
                'required' => false))
            ->add('Email', 'Symfony\Component\Form\Extension\Core\Type\EmailType', array(
                'label' => 'Correo electrónico',
                'required' => false,
                'attr' => array('autocomplete' => 'off', 'class' => 'tapir-input-minus')))
            ->add('TelefonoNumero', null, array('label' => 'Teléfonos'))
            ->add('FechaNacimiento', 'Tapir\BaseBundle\Form\Type\FechaPasadoPresenteType', array(
                'required' => false,
                'label' => 'Fecha de nacimiento'))
            ->add('Genero', 'Tapir\BaseBundle\Form\Type\GeneroType', array('label' => 'Género', 'required' => false))
            ->add('Cuilt',  'Tapir\BaseBundle\Form\Type\CuiltType', array(
                'label' => 'CUIL/CUIT',
                'required' => false))
            ->add('UsuarioRoles', 'Symfony\Bridge\Doctrine\Form\Type\EntityType', array(
                'label' => 'Roles',
                'class' => 'TapirBaseBundle:PersonaRol',
                'attr' => array('style' => 'width: 100%'),
                'multiple' => true,
                'required' => false));
    }
}
