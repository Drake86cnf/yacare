<?php
namespace Yacare\BaseBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DocumentoType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('DocumentoTipo', 'choice', array(
                'choices' => array(
                    '1' => 'DNI',
                    '2' => 'LE',
                    '3' => 'LC',
                    '4' => 'CI',
                    '5' => 'Pasaporte'
                ),
                'label' => 'Tipo'
            ))
            ->add('DocumentoNumero', null, array(
                'label' => 'Número',
                'attr' => array ( 'class' => 'tapir-input-documento')
            ))
            ->setAttribute('widget', 'form_horizontal');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'inherit_data' => true,
            'class' => 'form_horizontal'
        ));
    }

    public function getName()
    {
        return 'form_horizontal';
    }
}
