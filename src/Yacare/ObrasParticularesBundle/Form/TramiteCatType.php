<?php
namespace Yacare\ObrasParticularesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TramiteCatType extends \Yacare\TramitesBundle\Form\TramiteType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        
        $builder->add('Local', 'entity_id', 
            array('label' => 'Local','class' => 'Yacare\ComercioBundle\Entity\Local','required' => true))
            ->add('Actividad1', 'entity_id', 
            array(
                'label' => 'Actividad principal',
                'class' => 'Yacare\ComercioBundle\Entity\Actividad',
                'required' => true))
            ->add('Actividad2', 'entity_id', 
            array(
                'label' => 'Actividad secundaria',
                'class' => 'Yacare\ComercioBundle\Entity\Actividad',
                'required' => false))
            ->add('Actividad3', 'entity_id', 
            array(
                'label' => 'Actividad terciaria',
                'class' => 'Yacare\ComercioBundle\Entity\Actividad',
                'required' => false));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array('data_class' => 'Yacare\ObrasParticularesBundle\Entity\TramiteCat','cascade_validation' => true));
    }

    public function getName()
    {
        return 'yacare_obrasparticularesbundle_tramitecattype';
    }
}
