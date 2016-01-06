<?php
namespace Yacare\BaseBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

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
            ->add('DomicilioCalle', EntityType::class, array(
                'label' => 'Calle', 
                'class' => 'YacareCatastroBundle:Calle', 
                'required' => true, 
                'attr' => array('style' => 'width: 240px;')))
            ->add('DomicilioNumero', null, array(
                'label' => 'Nº', 
                'trim' => true, 
                'attr' => array('style' => 'width: 50px;'), 
                'required' => false))
            ->add('DomicilioPiso', null, array(
                'label' => 'Piso', 
                'trim' => true, 
                'attr' => array('style' => 'width: 32px;'), 
                'required' => false))
            ->add('DomicilioPuerta', null, array(
                'label' => 'Puerta', 
                'trim' => true, 
                'attr' => array('style' => 'width: 32px;'), 
                'required' => false))
            ->setAttribute('widget', 'form_horizontal');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('inherit_data' => true, 'attr' => array('class' => 'form-inline')));
    }
}
