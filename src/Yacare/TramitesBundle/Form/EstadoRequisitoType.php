<?php
namespace Yacare\TramitesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EstadoRequisitoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Estado', 'Tapir\BaseBundle\Form\Type\ButtonGroupType', array(
                'label' => 'Estado', 
                'required' => true,
                'attr' => array('vertical' => false, 'class' => 'tapir-input-320a'),
                'choices' => array(
                    'Faltante' => 0, 
                    'Observado' => 10, 
                    'Rechazado' => 15, 
                    'Presentado' => 95, 
                    'Aprobado' => '100')))
            ->add('Obs', null, array('label' => 'Observaciones', 'attr' => [ 'placeholder' => 'Observaciones']))
            ->add('EstoyTrabajando', null, array('label' => 'Estoy trabajando en esto'))
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'Yacare\TramitesBundle\Entity\EstadoRequisito'));
    }
}
