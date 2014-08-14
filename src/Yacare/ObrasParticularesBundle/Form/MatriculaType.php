<?php

namespace Yacare\ObrasParticularesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MatriculaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', null, array('label' => 'Legajo', 'read_only' => true))
            ->add('Nombre', null, array('label' => 'Nombres', 'required' => true))
            ->add('Apellido', null, array('label' => 'Apellidos', 'required' => true))
            ->add('username', null, array('label' => 'Nombre de usuario'))
            ->add('FechaIngreso', 'date', array(
                'years' => range(1900, 2099),
                'input' => 'datetime',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'label' => 'Fecha de ingreso'))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yacare\ObrasParticularesBundle\Entity\Matricula'
        ));
    }

    public function getName()
    {
        return 'yacare_obrasparticularesbundle_matriculatype';
    }
}
