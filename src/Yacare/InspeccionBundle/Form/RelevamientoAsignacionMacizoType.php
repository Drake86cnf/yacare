<?php
namespace Yacare\InspeccionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RelevamientoAsignacionMacizoType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('Relevamiento', 'entity', 
            array(
                'label' => 'Relevamiento',
                'class' => 'YacareInspeccionBundle:Relevamiento',
                'required' => true,
                'read_only' => true,
                'placeholder' => false,
                'property' => 'Nombre'))
            ->add('Encargado', 'entity_id', 
            array(
                'label' => 'Encargado',
                'property' => 'NombreVisible',
                'class' => 'Yacare\BaseBundle\Entity\Persona',
                'required' => true))
            ->add('Seccion', null, array('label' => 'Sección','required' => true))
            ->add('Macizo', null, array('label' => 'Macizo','required' => true));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array('data_class' => 'Yacare\InspeccionBundle\Entity\RelevamientoAsignacion'));
    }

    public function getName()
    {
        return 'yacare_inspeccionbundle_relevamientoasignaciontype';
    }
}
