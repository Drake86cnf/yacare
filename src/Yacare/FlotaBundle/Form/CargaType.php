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
            ->add('Vehiculo', 'Tapir\FormBundle\Form\Type\EntityHiddenType', array('class' => 'Yacare\FlotaBundle\Entity\Vehiculo', 'required' => false))
            ->add('Combustible', 'hidden')
            ->add('Litros', 'Tapir\TemplateBundle\Form\Type\IntegerType', array('label' => 'Litros'))
            ->add('Importe', 'Tapir\BaseBundle\Form\Type\ImporteType', array(
                'label' => 'Importe'))
            ->add('Kilometraje', 'Tapir\TemplateBundle\Form\Type\IntegerType', array(
                'label' => 'Kilometraje', 
                'required' => true, 
                'attr' => array(
                    'help' => 'El kilometraje del vehículo al momento de la carga.')))
            ;
            
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'Yacare\FlotaBundle\Entity\Carga'));
    }
}