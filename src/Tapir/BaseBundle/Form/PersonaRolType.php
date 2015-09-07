<?php
namespace Tapir\BaseBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Formulario para roles de personas.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class PersonaRolType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('Nombre', null, array('label' => 'Nombre'));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'Tapir\BaseBundle\Entity\PersonaRol'));
    }

    public function getName()
    {
        return 'tapir_basebundle_personaroltype';
    }
}
