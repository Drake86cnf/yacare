<?php
namespace Yacare\RecursosHumanosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AgenteType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('id', null, array(
                'label' => 'Legajo',
                'read_only' => true
            ))
            ->add('Grupos', 'entity', array(
                'label' => 'Grupos',
                'class' => 'YacareRecursosHumanosBundle:AgenteGrupo',
                'multiple' => true,
                'required' => false
            ))
            ->add('FechaIngreso', 'date', array(
                'years' => range(1900, 2099),
                'input' => 'datetime',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'label' => 'Fecha de ingreso'
            ))
            ->add('Persona', new \Yacare\BaseBundle\Form\PersonaType(), array(
                'label' => 'Persona asociada',
            ))
            ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yacare\RecursosHumanosBundle\Entity\Agente'
        ));
    }

    public function getName()
    {
        return 'yacare_recursoshumanosbundle_agentetype';
    }
}
