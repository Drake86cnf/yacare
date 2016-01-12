<?php
namespace Yacare\NominaBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Formulario para dispositivos GPS.
 * 
 * @author Ernesto Carrea ernestocarrea@gmail.com>
 */
class DispositivoRastreadorGpsType extends DispositivoType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        
        $builder->add('TelefonoNumero', null, array('label' => 'Nº de línea'));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'Yacare\NominaBundle\Entity\DispositivoRastreadorGps'));
    }
}
