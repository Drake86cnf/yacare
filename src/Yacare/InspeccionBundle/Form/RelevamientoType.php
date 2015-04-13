<?php
namespace Yacare\InspeccionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RelevamientoType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('Nombre', null, array('label' => 'Nombre'))->add('FechaInicio', 'date', 
            array(
                'years' => range(1900, 2099),
                'input' => 'datetime',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'label' => 'Fecha de inicio'));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array('data_class' => 'Yacare\InspeccionBundle\Entity\Relevamiento'));
    }

    public function getName()
    {
        return 'yacare_inspeccionbundle_relevamientotype';
    }
}
