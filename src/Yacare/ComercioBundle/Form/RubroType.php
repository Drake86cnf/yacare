<?php

namespace Yacare\ComprasBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RubroType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Codigo', null, array('label' => 'Código'))
            ->add('Nombre', null, array('label' => 'Nombre'))
            ->add('Categoria', 'choice', array(
                'label' => 'Categoría',
                'required'  => true,
                'choices' => array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6')
                ))
            ->add('Exento', 'choice', array(
                'label' => 'Exento',
                'required'  => true,
                'choices' => array('0' => 'No', '1' => 'Sí')
                ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yacare\ComercioBundle\Entity\Rubro'
        ));
    }

    public function getName()
    {
        return 'yacare_comerciobundle_rubrotype';
    }
}
