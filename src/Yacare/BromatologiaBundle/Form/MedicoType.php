<?php

namespace Yacare\BromatologiaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MedicoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder                 
            ->add('Medico', 'entity_id', array(
                'label' => 'Medico',
                'property' => 'NombreVisible',
                'class' => 'Yacare\BaseBundle\Entity\Persona',
                'filters' => array (
                    'filtro_grupo' => 1
                ),
                'required' => false))     
            ->add('Matricula', null, array('label' => 'Matrícula')) 
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yacare\BromatologiaBundle\Entity\Medico'
        ));
    }

    public function getName()
    {
        return 'yacare_bromatologiabundle_medicotype';
    }    
}
