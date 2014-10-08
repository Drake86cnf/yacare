<?php
namespace Tapir\BaseBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PersonaRolType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('Nombre', null, array(
            'label' => 'Nombre'
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Tapir\BaseBundle\Entity\PersonaRol'
        ));
    }

    public function getName()
    {
        return 'tapir_basebundle_personaroltype';
    }
}
