<?php

namespace Yacare\ComercioBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ActividadType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Clamae2014', null, array(
                'label' => 'Código ClaMAE 2014',
                'required' => true,
                'attr' => array('help'=>'No es necesario escribir los guiones. Para las divisiones 1 a la 9 prefijar con cero (01 a la 09).')
                ))
            ->add('Nombre', null, array('label' => 'Nombre'))
            ->add('Exento', 'choice', array(
                'label' => 'Exento',
                'required'  => true,
                'choices' => array('0' => 'No', '1' => 'Sí')
                ))
            ->add('RequiereDeyma', 'choice', array(
                'label' => 'Requiere DEyMA',
                'required'  => true,
                'choices' => array('0' => 'No', '1' => 'Sí')
                ))
            ->add('RequiereDbeh', 'choice', array(
                'label' => 'Requiere DBeH',
                'required'  => true,
                'choices' => array('0' => 'No', '1' => 'Sí')
                ))
            ->add('CategoriaAntigua', 'choice', array(
                'label' => 'Categoría antigua',
                'required'  => true,
                'choices' => array('0' => 'n/a', '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6')
                ))
            ->add('Incluye', null, array(
                'label' => 'Incluye',
                ))
            ->add('NoIncluye', null, array(
                'label' => 'No incluye',
                ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yacare\ComercioBundle\Entity\Actividad'
        ));
    }

    public function getName()
    {
        return 'yacare_comerciobundle_actividadtype';
    }
}
