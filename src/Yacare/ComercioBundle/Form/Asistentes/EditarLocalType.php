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
class EditarLocalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Local', new \Yacare\ComercioBundle\Form\LocalType(), array(
                'label' => 'Local',
                'property_path' => 'Comercio.Local'
            ))
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yacare\ComercioBundle\Entity\TramiteHabilitacionComercial',
            'validation_groups' => false
        ));
    }

    public function getName()
    {
        return 'yacare_comerciobundle_asistentes_editarlocaltype';
    }
}
