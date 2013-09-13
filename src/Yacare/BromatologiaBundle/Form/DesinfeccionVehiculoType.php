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
            ->add('Vehiculo', null, array('label' => 'Vehículo')) 
            ->add('FechaDesinfeccionVehiculo', 'date', array(
                'years' => range(1900, 2099),
                'widget' => 'single_text',
                'label' => 'Fecha de desinfección'))
            ->add('ComprobanteNumero', null, array('label' => 'Comprobante Nº'))    
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
