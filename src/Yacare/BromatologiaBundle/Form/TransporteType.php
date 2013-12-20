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
            ->add('Comercio', 'entity_id', array(
                'label' => 'Comercio',
                'class' => 'Yacare\ComercioBundle\Entity\Comercio'))
            ->add('Titular', 'entity_id', array(
                'label' => 'Titular',
                'property' => 'NombreVisible',
                'class' => 'Yacare\BaseBundle\Entity\Persona',
                'filters' => array (
                    'filtro_grupo' => 1
                ),
                'required' => false))        
            ->add('Domicilio', new \Yacare\BaseBundle\Form\Type\DomicilioLocalType(), 
                    array(
                        'data_class' => 'Yacare\BromatologiaBundle\Entity\Transporte',
                        'label' => 'Domicilio',
                        'required' => false))     
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
