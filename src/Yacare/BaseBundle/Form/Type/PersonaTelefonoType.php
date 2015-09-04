<?php
namespace Yacare\BaseBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Formulario para teléfonos.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class PersonaTelefonoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('TelefonoNumero', 'text', array('label' => 'Número', 'required' => true))
            ->add('TelefonoVerificacionNivel', 'choice', array(
                'choices' => array(
                    '0' => 'Sin confirmar', 
                    '10' => 'Confirmado', 
                    '20' => 'Cotejado', 
                    '30' => 'Certificado'), 
                'label' => 'Nivel', 
                'required' => true))
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
