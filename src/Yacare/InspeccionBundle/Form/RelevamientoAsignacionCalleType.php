<?php
namespace Yacare\InspeccionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Formulario de calle para asignación.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class RelevamientoAsignacionCalleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Relevamiento', 'entity', array(
                'label' => 'Relevamiento', 
                'class' => 'YacareInspeccionBundle:Relevamiento', 
                'required' => true, 
                'placeholder' => false,
                'attr' => array('readonly' => true)
            ))
            ->add('Encargado', 'Tapir\FormBundle\Form\Type\EntityIdType', array(
                'label' => 'Encargado', 
                // 'property' => 'NombreVisible', 
                'class' => 'Yacare\BaseBundle\Entity\Persona', 
                'required' => true))
            ->add('Calle', 'entity', array(
                'label' => 'Calle', 
                'class' => 'YacareCatastroBundle:Calle', 
                'required' => true, 
                'placeholder' => false));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yacare\InspeccionBundle\Entity\RelevamientoAsignacion'));
    }
}
