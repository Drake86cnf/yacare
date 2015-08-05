<?php
namespace Yacare\ComercioBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActividadComercioType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        
        $builder
            ->add('ActividadPrincipal', 'entity_id', 
                array('label' => 'Actividad 1', 'class' => 'Yacare\ComercioBundle\Entity\Actividad', 
                    'required' => true))
            ->add('ActividadSecundaria', 'entity_id', 
                array('label' => 'Actividad 2', 'class' => 'Yacare\ComercioBundle\Entity\Actividad', 
                    'required' => false))
            ->add('ActividadTerciaria', 'entity_id', 
                array('label' => 'Actividad 3', 'class' => 'Yacare\ComercioBundle\Entity\Actividad', 
                    'required' => false));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'Yacare\ComercioBundle\Entity\Comercio'));
    }

    public function getName()
    {
        return 'yacare_comerciobundle_actividadcomerciotype';
    }
}