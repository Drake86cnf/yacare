<?php

namespace Yacare\BromatologiaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CertificadoBpmType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder            
            ->add('Persona', null, array('label' => 'Persona'))
            ->add('Nota', null, array('label' => 'Nota'))
            ->add('FechaExamen', 'date', array(
                'years' => range(1900,2099),
                'input' => 'datetime',
                'widget' => 'single_text',
                'attr' => array('class' => 'datepicker'),
                'format' => 'dd/MM/yyyy',
                'label' => 'Fecha del examen'))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yacare\BromatologiaBundle\Entity\CertificadoBpm'
        ));
    }

    public function getName()
    {
        return 'yacare_bromatologiabundle_certificadobpmtype';
    }
}
