<?php
namespace Yacare\BaseBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Formulario para domicilio de un local.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class DomicilioLocalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('DomicilioCalle', 'Symfony\Bridge\Doctrine\Form\Type\EntityType', array(
                'label' => false,
                'class' => 'YacareCatastroBundle:Calle',
                'placeholder' => '(ninguna)',
                'empty_data' => 'n/a',
                'required' => false, 
                'attr' => array('style' => 'width: 240px;')))
            ->add('DomicilioNumero', null, array(
                'label' => false, 
                'trim' => true, 
                'attr' => array('placeholder' => 'Nº', 'class' => 'tapir-input-maymin', 'style' => 'width: 64px;'),
                'required' => false))
            ->add('DomicilioPiso', null, array(
                'label' => false, 
                'trim' => true, 
                'attr' => array('placeholder' => 'piso', 'class' => 'tapir-input-maymin', 'style' => 'width: 64px;'), 
                'required' => false))
            ->add('DomicilioPuerta', null, array(
                'label' => false, 
                'trim' => true, 
                'attr' => array('placeholder' => 'puerta', 'class' => 'tapir-input-maymin', 'style' => 'width: 64px;'), 
                'required' => false))
            ->setAttribute('widget', 'form_horizontal');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('inherit_data' => true, 'attr' => array('class' => 'form-inline')));
    }
}
