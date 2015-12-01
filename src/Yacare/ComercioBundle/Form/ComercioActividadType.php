<?php
namespace Yacare\ComercioBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Formulario grupal de actividades para un tipo de vista en particular.
 * 
 * @author Ezequiel Riquelme <rezequiel.tdf@gmail.com>
 */
class ComercioActividadType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        
        $builder
            ->add('Actividad1', 'Tapir\FormBundle\Form\Type\EntityIdType', array(
                'label' => 'Actividad 1', 
                'class' => 'Yacare\ComercioBundle\Entity\Actividad', 
                'required' => true))
            ->add('Actividad2', 'Tapir\FormBundle\Form\Type\EntityIdType', array(
                'label' => 'Actividad 2', 
                'class' => 'Yacare\ComercioBundle\Entity\Actividad', 
                'required' => false))
            ->add('Actividad3', 'Tapir\FormBundle\Form\Type\EntityIdType', array(
                'label' => 'Actividad 3', 
                'class' => 'Yacare\ComercioBundle\Entity\Actividad', 
                'required' => false))
            ->add('Actividad4', 'Tapir\FormBundle\Form\Type\EntityIdType', array(
                'label' => 'Actividad 4', 
                'class' => 'Yacare\ComercioBundle\Entity\Actividad', 
                'required' => false))
            ->add('Actividad5', 'Tapir\FormBundle\Form\Type\EntityIdType', array(
                'label' => 'Actividad 5', 
                'class' => 'Yacare\ComercioBundle\Entity\Actividad', 
                'required' => false))
            ->add('Actividad6', 'Tapir\FormBundle\Form\Type\EntityIdType', array(
                'label' => 'Actividad 6', 
                'class' => 'Yacare\ComercioBundle\Entity\Actividad', 
                'required' => false));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'Yacare\ComercioBundle\Entity\Comercio'));
    }
}
