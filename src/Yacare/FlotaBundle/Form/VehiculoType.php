<?php
namespace Yacare\FlotaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;

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
            ->add('Marca', null, array('label' => 'Marca', 'required' => false))
            ->add('Modelo', null, array('label' => 'Modelo'))
            ->add('Anio', null, array('label' => 'Año'))
            ->add('Color', null, array('label' => 'Color'))
            ->add('Combustible', 'Tapir\BaseBundle\Form\Type\ButtonGroupType', array(
                'label' => 'Combustible', 
                'required' => false, 
                'choices' => array(
                    'Sin especificar' => null, 
                    'Nafta' => 'nafta', 
                    'Nafta 98 oct.' => 'nafta-98', 
                    'Gasoil' => 'gasoil', 
                    'Gasoil grado 3' => 'gasoil-3', 
                    'GNC' => 'gnc')))
            ->add('IdentificadorUnico', null, array(
                'label' => 'Código', 
                'attr' => array('help' => 'El código Municipal de identificación del vehículo, por ejemplo L-71.')))
            ->add('Departamento', null, array(
                'label' => 'Sector', 
                'attr' => array('placeholder' => 'El sector al que pertenece el vehículo'), 
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.MaterializedPath', 'ASC');
                }, 
                'choice_label' => 'NombreConSangriaDeEspaciosDuros'))
            ->add('NumeroSerie', null, array('label' => 'Patente'));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'Yacare\FlotaBundle\Entity\Vehiculo'));
    }
}
