<?php
namespace Yacare\ComercioBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ComercioActividadType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        
        $builder
            ->add('Actividad1', 'entity_id', array(
                'label' => 'Actividad 1', 
                'class' => 'Yacare\ComercioBundle\Entity\Actividad', 
                'required' => true
                ))
            ->add('Actividad2', 'entity_id', array(
                'label' => 'Actividad 2', 
                'class' => 'Yacare\ComercioBundle\Entity\Actividad', 
                'required' => false
                ))
            ->add('Actividad3', 'entity_id', array(
                'label' => 'Actividad 3', 
                'class' => 'Yacare\ComercioBundle\Entity\Actividad', 
                'required' => false
                ))
            ->add('Actividad4', 'entity_id', array(
                'label' => 'Actividad 4', 
                'class' => 'Yacare\ComercioBundle\Entity\Actividad', 
                'required' => false
                ))
            ->add('Actividad5', 'entity_id', array(
                'label' => 'Actividad 5', 
                'class' => 'Yacare\ComercioBundle\Entity\Actividad', 
                'required' => false
                ))
            ->add('Actividad6', 'entity_id', array(
                'label' => 'Actividad 6', 
                'class' => 'Yacare\ComercioBundle\Entity\Actividad', 
                'required' => false
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yacare\ComercioBundle\Entity\Comercio'
        ));
    }

    public function getName()
    {
        return 'yacare_comerciobundle_comercioactividadtype';
    }
}
