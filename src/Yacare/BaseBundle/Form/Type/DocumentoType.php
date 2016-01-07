<?php
namespace Yacare\BaseBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Formulario para tipo de documento.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class DocumentoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('DocumentoTipo', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
                'choices' => array(
                    'DNI' => 1,
                    'LE' => 2,
                    'LC' => 3,
                    'CI' => 4,
                    'Pasaporte' => 5),
                'label' => false))
            ->add('DocumentoNumero', null, array(
                'label' => false,
                'attr' => array(
                    'class' => 'tapir-input-documento tapir-input-sinespacios',
                    'placeholder' => 'Número')))
            ->setAttribute('widget', 'form_horizontal');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('inherit_data' => true, 'attr' => array('class' => 'form-inline')));
    }
}
