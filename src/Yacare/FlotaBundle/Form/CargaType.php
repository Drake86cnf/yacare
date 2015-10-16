<?php
namespace Yacare\FlotaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * La carga de combustible que tiene un vehiculo.
 * 
 * @author Alejandro Díaz <alediaz.rc@gmail.com>
 */
class CargaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
             ->add('Vehiculo', null, array(
                   'label' => 'Vehículo',
                   'required' => true,
                   'attr' => array(
                   'help' => 'El vehículo que va a realizar la carga'))) 
            ->add('Litros', null, array('label' => 'Cantidad de Litros'))
            ->add('Kilometraje', null, array(
                'label' => 'Kilometraje', 
                'required' => true, 
                'attr' => array(
                    'help' => 'El kilometraje del auto cuando carga')))
            ->add('Importe', null, array(
                'label' => 'Importe de la carga',
                ))
            ->add('Combustible', null, array('label' => 'Tipo de combustible'));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'Yacare\FlotaBundle\Entity\Carga'));
    }

    public function getName()
    {
        return 'yacare_flotabundle_cargatype';
    }
}