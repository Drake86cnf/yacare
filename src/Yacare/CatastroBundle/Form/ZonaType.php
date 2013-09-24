<?php

namespace Yacare\CatastroBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ZonaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Codigo', null, array('label' => 'Código'))
            ->add('Nombre', null, array('label' => 'Nombre'))
            ->add('Fos', null, array('label' => 'F.O.S.'))
            ->add('Fot', null, array('label' => 'F.O.T.'))
            ->add('Obs', null, array('label' => 'Obs.'))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yacare\CatastroBundle\Entity\Zona'
        ));
    }

    public function getName()
    {
        return 'yacare_catastrobundle_zonatype';
    }
}
