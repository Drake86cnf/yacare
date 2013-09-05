<?php

namespace Yacare\BromatologiaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DesinfeccionVehiculoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder                 
            ->add('Vehiculo', null, array('label' => 'Vehiculo')) 
            ->add('FechaDesinfeccion', 'date', array(
                'years' => range(1900,2099),
                'input' => 'datetime',
                'widget' => 'single_text',
                'attr' => array('class' => 'datepicker'),
                'format' => 'dd/MM/yyyy',
                'label' => 'Fecha del desinfeccion'))
            ->add('ComprobanteNumero', null, array('label' => 'Comprobante Numero'))    
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yacare\BromatologiaBundle\Entity\DesinfeccionVehiculo'
        ));
    }

    public function getName()
    {
        return 'yacare_bromatologiabundle_desinfeccionvehiculotype';
    }    
}
