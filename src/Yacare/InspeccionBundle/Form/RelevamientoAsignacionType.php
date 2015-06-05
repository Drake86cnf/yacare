<?php
namespace Yacare\InspeccionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RelevamientoAsignacionType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('Relevamiento', 'entity', 
            array(
                'label' => 'Relevamiento',
                'class' => 'YacareInspeccionBundle:Relevamiento',
                'required' => true,
                'placeholder' => false,
                'property' => 'Nombre'))
            ->add('Encargado', 'entity_id', 
            array(
                'label' => 'Encargado',
                'property' => 'NombreVisible',
                'class' => 'Yacare\BaseBundle\Entity\Persona',
                'required' => true))
            ->add('Calle', 'entity', 
            array(
                'label' => 'Calle',
                'class' => 'YacareCatastroBundle:Calle',
                'required' => false,
                'placeholder' => 'Ninguna',
                'property' => 'Nombre'))
            ->add('Seccion', null, array('label' => 'Sección'))
            ->add('Macizo', null, array('label' => 'Macizo'));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array('data_class' => 'Yacare\InspeccionBundle\Entity\RelevamientoAsignacion'));
    }

    public function getName()
    {
        return 'yacare_inspeccionbundle_relevamientoasignaciontype';
    }
}
