<?php

namespace Yacare\ComercioBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class LocalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Propietario', null, array('label' => 'Propietario'))             
            ->add('TipoLugar', null, array('label' => 'Tipo'))
            ->add('DomicilioCalle', new \Yacare\BaseBundle\Form\DomicilioLocalType(), 
                    array(
                        'data_class' => 'Yacare\ComercioBundle\Entity\Local',
                        'label' => 'Domicilio')
                    )
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yacare\ComercioBundle\Entity\Local'
        ));
    }

    public function getName()
    {
        return 'yacare_comerciobundle_localtype';
    }    
}
