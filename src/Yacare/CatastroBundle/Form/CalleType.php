<?php
namespace Yacare\CatastroBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CalleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Nombre', null, array(
                'label' => 'Nombre'))
            ->add('NombreAlternativo', null, array(
                'label' => 'Nombre alternativo'))
            ->add('Tipo', new \Tapir\BaseBundle\Form\Type\ButtonGroupType(), array(
                'label' => 'Tipo', 
                'choices' => array(
                    0 => 'Calle', 
                    1 => 'Avenida', 
                    2 => 'Bulevar', 
                    3 => 'Pasaje')));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yacare\CatastroBundle\Entity\Calle'));
    }

    public function getName()
    {
        return 'yacare_catastrobundle_calletype';
    }
}
