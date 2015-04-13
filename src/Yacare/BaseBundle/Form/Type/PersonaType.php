<?php
namespace Yacare\BaseBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PersonaType extends AbstractType
{

    public function setDefaultOptions(OptionsResolverInterface $resolver)
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
