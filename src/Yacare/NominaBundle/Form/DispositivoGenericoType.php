<?php
namespace Yacare\NominaBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Formulario para dispositvo genérico.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class DispositivoGenericoType extends DispositivoType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'Yacare\NominaBundle\Entity\DispositivoGenerico'));
    }
}
