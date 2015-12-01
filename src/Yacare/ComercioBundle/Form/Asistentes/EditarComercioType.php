<?php
namespace Yacare\ComercioBundle\Form\Asistentes;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Formulario para editar los datos básicos de una persona.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class EditarComercioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Comercio', 'Yacare\ComercioBundle\Form\ComercioSimpleType', array(
                'label' => 'Comercio'))
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yacare\ComercioBundle\Entity\TramiteHabilitacionComercial',
            'validation_groups' => false
        ));
    }
}
