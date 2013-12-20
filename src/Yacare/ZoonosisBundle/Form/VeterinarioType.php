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
            ->add('Veterinario', 'entity_id', array(
                'label' => 'Veterinario',
                'class' => 'Yacare\BaseBundle\Entity\Persona',
                'filters' => array (
                    'filtro_grupo' => 1
                )))
            ->add('Matricula', null, array('label' => 'Matrícula'))             
            ->add('Clinica', 'entity_id', array(
                'label' => 'Clinica',
                'class' => 'Yacare\ComercioBundle\Entity\Comercio'))
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
