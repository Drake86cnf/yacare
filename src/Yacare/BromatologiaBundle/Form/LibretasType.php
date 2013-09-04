<?php

namespace Yacare\BromatologiaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class LibretasType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder            
            ->add('Persona', null, array('label' => 'Persona'))            
            ->add('FechaCertificado', 'date', array(
                'years' => range(1900,2099),
                'input' => 'datetime',
                'widget' => 'single_text',
                'attr' => array('class' => 'datepicker'),
                'format' => 'dd/MM/yyyy',
                'label' => 'Fecha del certificado'))
            ->add('Profesional', null, array('label' => 'Profesional'))
            ->add('Curso', null, array('label' => 'Curso'))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yacare\BromatologiaBundle\Entity\Libretas'
        ));
    }

    public function getName()
    {
        return 'yacare_bromatologiabundle_libretas';
    }
}
