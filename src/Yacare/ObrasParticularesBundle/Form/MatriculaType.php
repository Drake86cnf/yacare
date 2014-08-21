<?php

namespace Yacare\ObrasParticularesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MatriculaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('Nombre', 'entity_id' , array(
                'label' => 'Nombre',
                'class' => 'Yacare\BaseBundle\Entity\Persona',
                'required'  => true))
            ->add('Partida', 'entity_id', array(
                'label' => 'Partida',
                'class' => 'Yacare\CatastroBundle\Entity\Partida',
                'required' => true))
                
            ->add('Profesion', 'choice', array(
                'label' => 'Profesion',
                'required'  => true,
                'choices' => array(
                    'Ingeniero Civil' => 'Ingeniero Civil',
                    'Arquitecto' => 'Arquitecto',
                    'Maestro Mayor de Obras' => 'M.M Obras',
                    'Tecnico Constructor' => 'T. Constructor',
                    'Otro' => 'Otro'
                    )
                ))
            ->add('Estado', 'choice', array(
                'label' => 'Estado',
                'required'  => true,
                'choices' => array(
                    'Habilitado' => 'Habilitado',
                    'No Habilitado' => 'No Habilitado',
                    
                    )
                ))
                ->add('FechaVencimiento', 'date', array(
                'years' => range(1900, 2099),
                'input' => 'datetime',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'label' => 'Fecha de Vencimiento'))
                ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yacare\ObrasParticularesBundle\Entity\Matricula',
            'cascade_validation' => true,
        ));
    }

    public function getName()
    {
        return 'yacare_obrasparticularesbundle_matriculatype';
    }
}
