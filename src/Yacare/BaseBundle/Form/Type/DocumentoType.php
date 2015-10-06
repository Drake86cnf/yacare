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
            ->add('DocumentoTipo', 'choice', array(
                'choices' => array(
                    '1' => 'DNI',
                    '2' => 'LE',
                    '3' => 'LC',
                    '4' => 'CI',
                    '5' => 'Pasaporte'),
                'label' => false))
            ->add('DocumentoNumero', null, array(
                'label' => false,
                'attr' => array(
                    'class' => 'tapir-input-documento',
                    'placeholder' => 'Número')))
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
