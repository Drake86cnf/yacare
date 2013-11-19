<?php

namespace Yacare\ComercioBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TramiteHabilitacionComercialConsultaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('Partida', 'entity_id', array(
                'label' => 'Partida',
                'class' => 'Yacare\CatastroBundle\Entity\Partida',
                'required'  => true
                ))
            ->add('ActividadPrincipal', 'entity_id', array(
                'label' => 'Actividad principal',
                'class' => 'Yacare\ComercioBundle\Entity\Actividad',
                'required'  => true
                ))
                ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yacare\ComercioBundle\Entity\TramiteHabilitacionComercial'
        ));
    }

    public function getName()
    {
        return 'yacare_tramitesbundle_tramitehabilitacioncomercialconsultatype';
    }
}
