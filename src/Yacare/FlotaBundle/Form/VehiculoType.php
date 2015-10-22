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
            ->add('Marca', null, array(
                'label' => 'Marca', 
                'required' => false
            ))
            ->add('Modelo', null, array('label' => 'Modelo'))
            ->add('Anio', null, array('label' => 'Año'))
            ->add('Color', null, array('label' => 'Color'))
            ->add('Combustible', new \Tapir\BaseBundle\Form\Type\ButtonGroupType(), array(
                'label' => 'Combustible',
                'required' => false,
                'choices' => array(
                    null => 'Sin especificar',
                    'nafta' => 'Nafta',
                    'nafta-98' => 'Nafta 98 oct.',
                    'gasoil' => 'Gasoil',
                    'gasoil-3' => 'Gasoil grado 3',
                    'gnc' => 'GNC')))
            
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
                'property' => 'NombreConSangriaDeEspaciosDuros'))
            ->add('NumeroSerie', null, array('label' => 'Patente')
            );
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
