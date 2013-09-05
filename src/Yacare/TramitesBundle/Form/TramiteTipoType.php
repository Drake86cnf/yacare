<?php

namespace Yacare\TramitesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TramiteTipoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Nombre', null, array('label' => 'Nombre'))
            ->add('Clase', null, array('label' => 'Clase'))
            ->add('Url', null, array(
                'label' => 'Web',
                'attr'  => array('placeholder' => 'Sitio web con información')
                ))
            ->add('Obs', null, array(
                'label' => 'Obs.',
                'attr' => array(
                    'class' => 'tinymce',
                    'data-theme' => 'simple') // simple, advanced, bbcode
                ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yacare\TramitesBundle\Entity\TramiteTipo'
        ));
    }

    public function getName()
    {
        return 'yacare_tramitesbundle_tramitetipotype';
    }
}