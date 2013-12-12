<?php

namespace Yacare\ComercioBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TramiteHabilitacionComercialType extends \Yacare\TramitesBundle\Form\TramiteType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('Comercio', new ComercioSimpleType(), array(
                'label' => 'Datos del comercio'
                ))
                ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yacare\ComercioBundle\Entity\TramiteHabilitacionComercial',
            'cascade_validation' => true,
        ));
    }

    public function getName()
    {
        return 'yacare_tramitesbundle_tramitehabilitacioncomercialtype';
    }
}
