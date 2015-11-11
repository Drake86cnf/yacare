<?php
namespace Yacare\ComercioBundle\Form\Asistentes;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Formulario para buscar o crear una persona.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class BuscarLocalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Local', 'entity_id', array(
                'label' => 'Local',
                'property_path' => 'Comercio.Local',
                'class' => 'Yacare\ComercioBundle\Entity\Local',
                'searchtype' => 'inline',
                'required' => true))
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'Yacare\ComercioBundle\Entity\TramiteHabilitacionComercial'));
    }

    public function getName()
    {
        return 'yacare_comerciobundle_asistentes_buscarlocaltype';
    }
}
