<?php

namespace Yacare\ObrasParticularesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TramiteCatType extends \Yacare\TramitesBundle\Form\TramiteType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('Local', 'entity_id', array(
                'label' => 'Local',
                'class' => 'Yacare\ComercioBundle\Entity\Local',
                'required'  => true
                ))
            ->add('ActividadPrincipal', 'entity_id', array(
                'label' => 'Actividad principal',
                'class' => 'Yacare\ComercioBundle\Entity\Actividad',
                'required'  => true
                ))
            ->add('ActividadSecundaria', 'entity_id', array(
                'label' => 'Actividad secundaria',
                'class' => 'Yacare\ComercioBundle\Entity\Actividad',
                'required'  => false
                ))
            ->add('ActividadTerciaria', 'entity_id', array(
                'label' => 'Actividad terciaria',
                'class' => 'Yacare\ComercioBundle\Entity\Actividad',
                'required'  => false
                ))
                ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yacare\ObrasParticularesBundle\Entity\TramiteCat',
            'cascade_validation' => true,
        ));
    }

    public function getName()
    {
        return 'yacare_obrasparticularesbundle_tramitecattype';
    }
}
