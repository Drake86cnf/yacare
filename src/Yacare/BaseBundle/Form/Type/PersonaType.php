<?php
namespace Yacare\BaseBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonaType extends AbstractType
{

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array('read_only' => false,'data_class' => 'Yacare\BaseBundle\Entity\Persona'));
    }

    public function getParent()
    {
        return 'text';
    }

    public function getName()
    {
        return 'persona';
    }
}
