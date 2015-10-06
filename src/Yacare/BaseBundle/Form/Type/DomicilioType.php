<?php
namespace Yacare\BaseBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Formulario para domicilios.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class DomicilioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('DomicilioCalle', 'entity', array(
                'label' => false,
                'class' => 'YacareCatastroBundle:Calle',
                'required' => false,
                'attr' => array('class' => 'tapir-input-240'),
                'placeholder' => 'Otra (escribir a continuación)',
                'query_builder' => function (\Tapir\BaseBundle\Entity\TapirBaseRepository $er) {
                    return $er->createQueryBuilder('i');
                }))
            ->add('DomicilioCalleNombre', null, array(
                'label' => false,
                'attr' => array('placeholder' => 'Calle'),
                'required' => false))
            ->add('DomicilioNumero', null, array(
                'label' => false,
                'trim' => true,
                'attr' => array('placeholder' => 'Nº', 'style' => 'width: 64px;'),
                'required' => false))
            ->add('DomicilioPiso', null, array(
                'label' => false,
                'trim' => true,
                'attr' => array('placeholder' => 'piso', 'style' => 'width: 64px;'),
                'required' => false))
            ->add('DomicilioPuerta', null, array(
                'label' => false,
                'trim' => true,
                'attr' => array('placeholder' => 'puerta', 'style' => 'width: 64px;'),
                'required' => false))
            ->setAttribute('widget', 'form_horizontal');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('inherit_data' => true, 'class' => 'form_horizontal'));
    }

    public function getName()
    {
        return 'form_horizontal';
    }
}
