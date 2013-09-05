<?php

namespace Yacare\BromatologiaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TipoAnalisisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Nombre', null, array('label' => 'Nombre')) 
            ->add('Costo', null, array('label' => 'Costo'))           
            ->add('Tipo', 'choice', array(
                'choices'   => array(
                    '1' => 'Físico Químico',
                    '2' => 'Microbiológico',
                    ),
                'required'  => true,
                'label' => 'Tipo'))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yacare\BromatologiaBundle\Entity\TipoAnalisis'
        ));
    }

    public function getName()
    {
        return 'yacare_bromatologiabundle_tipoanalisistype';
    }    
}
