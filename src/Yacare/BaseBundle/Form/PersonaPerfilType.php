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
            ->add('NombreVisible', null, array('label' => 'Nombre', 'read_only' => true))
            ->add('Email', 'email', array(
                'label' => 'Correo electrónico',
                'attr' => array('autocomplete' => 'off', 'class' => 'tapir-input-minus')
            ))
            ->add('TelefonoNumero', null, array('label' => 'Teléfonos'))
            ->add('FechaNacimiento', new \Tapir\BaseBundle\Form\Type\FechaPasadoPresenteType(), array(
                'required' => false,
                'label' => 'Fecha de nacimiento'))
            ->add('Genero', new \Tapir\BaseBundle\Form\Type\GeneroType(), array('label' => 'Género', 'required' => true))
            ->add('Cuilt',  new \Tapir\BaseBundle\Form\Type\CuiltType(), array(
                'label' => 'CUIL/CUIT',
                'required' => false
            ))
            //->add('Username', null, array('label' => 'Nombre de usuario', 'required' => false))
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'Yacare\BaseBundle\Entity\Persona'));
    }

    public function getName()
    {
        return 'yacare_basebundle_personaperfiltype';
    }
}
