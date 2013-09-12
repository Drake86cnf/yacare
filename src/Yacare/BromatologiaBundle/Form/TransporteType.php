<?php

namespace Yacare\BromatologiaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TransporteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Nombre', null, array('label' => 'Nombre')) 
            ->add('Titular', null, array('label' => 'Titular'))    
            ->add('Domicilio', new \Yacare\BaseBundle\Form\DomicilioLocalType(), 
                    array(
                        'data_class' => 'Yacare\BromatologiaBundle\Entity\Transporte',
                        'label' => 'Domicilio')
                    )     
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yacare\BromatologiaBundle\Entity\Transporte'
        ));
    }

    public function getName()
    {
        return 'yacare_bromatologiabundle_transportetype';
    }    
}
