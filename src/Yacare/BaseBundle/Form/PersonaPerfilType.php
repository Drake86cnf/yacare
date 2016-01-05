<?php
namespace Yacare\BaseBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Formulario perfil de usuario.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class PersonaPerfilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('NombreVisible', null, array('label' => 'Nombre'))
            ->add('Email', 'email', array(
                'label' => 'Correo electrónico',
                'required' => false,
                'attr' => array('autocomplete' => 'off', 'readonly' => true, 'class' => 'tapir-input-minus')
            ))
            ->add('TelefonoNumero', null, array('label' => 'Teléfonos'))
            ->add('FechaNacimiento', 'Tapir\BaseBundle\Form\Type\FechaPasadoPresenteType', array(
                'required' => false,
                'label' => 'Fecha de nacimiento'))
            ->add('Genero', 'Tapir\BaseBundle\Form\Type\GeneroType', array('label' => 'Género', 'required' => false))
            ->add('Cuilt',  'Tapir\BaseBundle\Form\Type\CuiltType', array(
                'label' => 'CUIL/CUIT',
                'required' => false
            ))
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'Yacare\BaseBundle\Entity\Persona'));
    }
}
