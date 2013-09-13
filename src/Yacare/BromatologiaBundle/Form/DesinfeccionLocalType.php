<?php

namespace Yacare\BromatologiaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DesinfeccionLocalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder                 
            ->add('Local', null, array('label' => 'Local')) 
            ->add('Titular', null, array('label' => 'Propietario'))
            ->add('FechaDesinfeccionLocal', 'date', array(
                'years' => range(1900, 2099),
                'widget' => 'single_text',
                'label' => 'Fecha de desinfección'))
            ->add('TipoDesinfeccionLocal', 'choice', array(
                'choices'   => array(
                    '1' => 'Desinfección',
                    '2' => 'Desinsectación',
                    '3' => 'Desratización',
                    ),
                'required'  => true,
                'label' => 'Tipo de desinfeccion'))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yacare\BromatologiaBundle\Entity\DesinfeccionLocal'
        ));
    }

    public function getName()
    {
        return 'yacare_bromatologiabundle_desinfeccionlocaltype';
    }    
}
