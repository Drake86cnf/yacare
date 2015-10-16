<?php
namespace Yacare\FlotaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Formulario para un vehiculo perteneciente al municipio.
 * 
 * @author Alejandro Díaz <alediaz.rc@gmail.com>
 */
class VehiculoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Marca', null, array(
                'label' => 'Marca', 
                'required' => false, 
                'attr' => array(
                    'help' => 'Marca del vehículo en particular')))
            ->add('Modelo',null, array('label' => 'Modelo'))
            ->add('IdentificadorUnico', null, array(
                'label' => 'Codigo del vehículo',
                 'attr' => array(
                    'help'=>'El código identificador ej (l-71)')))
            ->add('Departamento', null, array('label' => 'Area',
                  'attr' => array(
                  'placeholder'=> 'Dirección a la que pertenece el vehículo')))
            ->add('NumeroSerie', null, array('label' => 'Patente'))
            ->add('Combustible', null, array('label' => 'Combustible', 
                  'attr'=> array(
                  'placeholder'=>'Tipo de combustible que utiliza')))
            ->add('Anio', null, array('label' => 'Año del auto'))
            ->add('Color', null, array('label' => 'Color'))
            ->add('Combustible', new \Tapir\BaseBundle\Form\Type\ButtonGroupType(), array(
                'label' => 'Tipo de combustible',
                'required'=> true,
                'choices'=> array (
                    'nafta' =>'Nafta Comun',
                    'nafta-98' =>'Nafta 98',
                    'gasoil' =>'Gasoil',
                    'gasoil-3' =>'Gasoil grado 3',
                    'Gnc'=> 'GNC')));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'Yacare\FlotaBundle\Entity\Vehiculo'));
    }

    public function getName()
    {
        return 'yacare_flotabundle_vehiculotype';
    }
}