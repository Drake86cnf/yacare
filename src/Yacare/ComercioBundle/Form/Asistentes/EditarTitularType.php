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
class EditarTitularType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            /* ->add('Titular', 'Yacare\BaseBundle\Form\PersonaType', array(
                'label' => 'Titular')) */
            ->add('TitularNombre', null, array(
                'property_path' => 'Titular.Nombre',
                'label' => 'Nombre'))
            ->add('TitularApellido', null, array(
                'property_path' => 'Titular.Apellido',
                'label' => 'Apellido'))
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
