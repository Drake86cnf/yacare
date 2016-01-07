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
            ->add('TelefonoNumero', null, array('label' => 'Número', 'required' => true))
            ->add('TelefonoVerificacionNivel', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
                'choices' => array(
                    'Sin confirmar' => 0, 
                    'Confirmado' => 10, 
                    'Cotejado' => 20, 
                    'Certificado' => 30), 
                'label' => 'Nivel', 
                'required' => true))
            ->setAttribute('widget', 'form_horizontal');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('inherit_data' => true, 'class' => 'form_horizontal'));
    }
}
