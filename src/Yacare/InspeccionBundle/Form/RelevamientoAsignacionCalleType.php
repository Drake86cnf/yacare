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
            ->add('Relevamiento', 'Symfony\Bridge\Doctrine\Form\Type\EntityType', array(
                'label' => 'Relevamiento', 
                'class' => 'YacareInspeccionBundle:Relevamiento', 
                'required' => true,
                'attr' => array('readonly' => true)
            ))
            ->add('Encargado', 'Tapir\FormBundle\Form\Type\EntityIdType', array(
                'label' => 'Encargado', 
                'property' => 'NombreVisible', 
                'class' => 'Yacare\BaseBundle\Entity\Persona', 
                'required' => true))
            ->add('Calle', 'Symfony\Bridge\Doctrine\Form\Type\EntityType', array(
                'label' => 'Calle', 
                'class' => 'YacareCatastroBundle:Calle', 
                'required' => true));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yacare\InspeccionBundle\Entity\RelevamientoAsignacion'));
    }
}
