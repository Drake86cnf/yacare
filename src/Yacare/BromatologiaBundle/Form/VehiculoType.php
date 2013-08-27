<?php

namespace Yacare\BromatologiaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class VehiculoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Transporte', null, array('label' => 'Transporte'))
            ->add('Dominio', null, array('label' => 'Dominio'))
            ->add('Marca', null, array('label' => 'Marca'))
            ->add('Modelo', null, array('label' => 'Modelo'))
            ->add('Ano', null, array('label' => 'Año'))
            ->add('Peso', null, array('label' => 'Peso'))            
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yacare\BromatologiaBundle\Entity\Vehiculo'
        ));
    }

    public function getName()
    {
        return 'yacare_bromatologiabundle_vehiculotype';
    }
}
