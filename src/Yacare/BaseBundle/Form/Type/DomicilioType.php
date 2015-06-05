<?php
namespace Yacare\BaseBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DomicilioType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('DomicilioCalle', 'entity', 
            array(
                'label' => 'Calle',
                'class' => 'YacareCatastroBundle:Calle',
                'required' => false,
                'attr' => array('style' => 'width: 240px;'),
                'placeholder' => 'Otra (escribir a continuación)',
                'query_builder' => function (\Tapir\BaseBundle\Entity\TapirBaseRepository $er)
                {
                    return $er->createQueryBuilder('i');
                }))
            ->add('DomicilioCalleNombre', null, 
            array('label' => ' ','attr' => array('placeholder' => 'Nombre de la calle'),'required' => false))
            ->add('DomicilioNumero', null, 
            array(
                'label' => ' ',
                'trim' => true,
                'attr' => array('placeholder' => 'Nº','style' => 'width: 60px;'),
                'required' => false))
            ->add('DomicilioPiso', null, 
            array(
                'label' => ' ',
                'trim' => true,
                'attr' => array('placeholder' => 'piso','style' => 'width: 55px;'),
                'required' => false))
            ->add('DomicilioPuerta', null, 
            array(
                'label' => ' ',
                'trim' => true,
                'attr' => array('placeholder' => 'puerta','style' => 'width: 55px;'),
                'required' => false))
            ->setAttribute('widget', 'form_horizontal');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array('inherit_data' => true,'class' => 'form_horizontal'));
    }

    public function getName()
    {
        return 'form_horizontal';
    }
}
