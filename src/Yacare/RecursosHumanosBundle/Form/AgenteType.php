<?php
namespace Yacare\RecursosHumanosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AgenteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', null, array(
                'label' => 'Legajo', 
                'attr' => array('readonly' => true)))
            ->add('Grupos', 'entity', array(
                'label' => 'Grupos', 
                'class' => 'YacareRecursosHumanosBundle:AgenteGrupo', 
                'multiple' => true, 
                'required' => false, 
                'query_builder' => function (\Tapir\BaseBundle\Entity\TapirBaseRepository $er) {
                    return $er->createQueryBuilder('i');
                }))
            ->add('FechaIngreso', 'Tapir\BaseBundle\Form\Type\FechaPasadoPresenteType', array(
                'required' => true,
                'label' => 'Fecha de ingreso'))
            ->add('Persona', 'Yacare\RecursosHumanosBundle\Form\PersonaAgenteType', array(
                'label' => 'Persona'));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yacare\RecursosHumanosBundle\Entity\Agente'));
    }
}
