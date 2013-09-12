<?php

namespace Yacare\CatastroBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PartidaPorCalleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Calle', 'entity', array(
                'label' => 'Calle',
                'class' => 'YacareCatastroBundle:Calle',
                'required' => true,
                'mapped' => false,
                'property' => 'Nombre'
                ))
            ->add('CalleNumero', null, array(
                'label' => 'Nº',
                'mapped' => false,
                ))
            ->setAttribute('widget', 'form_horizontal')
        ;
    }
    
        public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'inherit_data' => true,
            'class' => 'form_horizontal'
        ));
    }

    public function getName()
    {
        return 'form_horizontal';
    }
}
