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
                'attr' => array('vertical' => true, 'class' => 'tapir-input-320'),
                'choices' => array(
                    '0' => 'Faltante', 
                    '10' => 'Observado', 
                    '15' => 'Rechazado', 
                    '90' => 'Desestimado', 
                    '95' => 'Presentado pendiente de aprobación', 
                    '100' => 'Aprobado')))
            ->add('Obs', null, array('label' => 'Obs.'))
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'Yacare\TramitesBundle\Entity\EstadoRequisito'));
    }
}
