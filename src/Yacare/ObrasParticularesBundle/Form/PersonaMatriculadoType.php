<?php
namespace Yacare\ObrasParticularesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Formulario para datos personales de un matriculado.
 *
 * @author Ezequiel Riquelme <rezequiel.tdf@gmail.com>
 */
class PersonaMatriculadoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Domicilio', 'Yacare\BaseBundle\Form\Type\DomicilioType', array(
                'label' => 'Domicilio',
                'required' => false))
            ->add('TelefonoNumero', null, array(
                'label' => 'Teléfonos',
                'attr' => array('class' => 'tapir-input-maymin')))
            ->add('Email', 'Symfony\Component\Form\Extension\Core\Type\EmailType', array(
                'label' => 'Correo electrónico',
                'required' => false,
                'attr' => array('autocomplete' => 'off', 'class' => 'tapir-input-minus tapir-input-sinespacios')));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'Yacare\BaseBundle\Entity\Persona'));
    }
}
