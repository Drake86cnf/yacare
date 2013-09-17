<?php

namespace Yacare\ZoonosisBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class VeterinarioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder                 
            ->add('Veterinario', null, array('label' => 'Veterinario')) 
            ->add('Matricula', null, array('label' => 'Matrícula')) 
            ->add('Clinica', null, array('label' => 'Clinica')) 
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yacare\ZoonosisBundle\Entity\Veterinario'
        ));
    }

    public function getName()
    {
        return 'yacare_zoonosisbundle_veterinariotype';
    }    
}
