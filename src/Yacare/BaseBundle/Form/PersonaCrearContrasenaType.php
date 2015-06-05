<?php
namespace Yacare\BaseBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonaCrearContrasenaType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('PasswordEnc', 'password', 
            array('label' => 'Contraseña nueva','required' => true))->add('ContrasenaNueva2', 'password', 
            array('label' => 'Repetir contraseña','required' => true,'mapped' => false));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'Yacare\BaseBundle\Entity\Persona'));
    }

    public function getName()
    {
        return 'yacare_basebundle_personacrearcontrasenatype';
    }
}
