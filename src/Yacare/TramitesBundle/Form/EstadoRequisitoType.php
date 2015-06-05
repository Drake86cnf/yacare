<?php
namespace Yacare\TramitesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EstadoRequisitoType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('Estado', 'choice', 
            array(
                'label' => 'Estado',
                'required' => true,
                'choices' => array(
                    '0' => 'Faltante',
                    '10' => 'Observado',
                    '15' => 'Rechazado',
                    '90' => 'Desestimado',
                    '95' => 'Presentado pendiente de aprobación',
                    '100' => 'Aprobado')))
            ->add('Obs', null, array('label' => 'Obs.'))
            ->add('Adjuntos', 'adjuntos', 
            array(
                'label' => 'Adjuntar archivos',
                'required' => false,
                'class' => 'Yacare\BaseBundle\Entity\Adjunto',
                'data_class' => null));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array('data_class' => 'Yacare\TramitesBundle\Entity\EstadoRequisito'));
    }

    public function getName()
    {
        return 'yacare_tramitesbundle_estadorequisitoype';
    }
}
