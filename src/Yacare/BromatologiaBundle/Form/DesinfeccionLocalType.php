<?php
namespace Yacare\BromatologiaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DesinfeccionLocalType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('Local', 'entity_id', array(
            'label' => 'Local',
            'class' => 'Yacare\ComercioBundle\Entity\Local',
            'required' => true
        ))
            ->add('Titular', 'entity_id', array(
            'label' => 'Titular',
            'property' => 'NombreVisible',
            'class' => 'Yacare\BaseBundle\Entity\Persona',
            'filters' => array(
                'filtro_grupo' => 1
            ),
            'required' => false
        ))
            ->add('FechaDesinfeccionLocal', 'date', array(
            'years' => range(1900, 2099),
            'widget' => 'single_text',
            'label' => 'Fecha de desinfección'
        ))
            ->add('TipoDesinfeccionLocal', 'choice', array(
            'choices' => array(
                '1' => 'Desinfección',
                '2' => 'Desinsectación',
                '3' => 'Desratización'
            ),
            'required' => true,
            'label' => 'Tipo de desinfeccion'
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yacare\BromatologiaBundle\Entity\DesinfeccionLocal'
        ));
    }

    public function getName()
    {
        return 'yacare_bromatologiabundle_desinfeccionlocaltype';
    }
}
