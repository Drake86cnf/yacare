<?php
namespace Yacare\BaseBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Campo de formulario para seleccionar una persona.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class PersonaType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired(array('class'));
        $resolver->setDefaults(
            array(
                'property' => 'NombreVisible',
                'extra_data' => 'DocumentoNumero,Cuilt',
                'placeholder' => 'Seleccione una persona',
                'class' => 'Yacare\BaseBundle\Entity\Persona'
            ));
    }

    public function getParent()
    {
        return 'tapir_ajax_entity';
    }

    public function getName()
    {
        return 'yacare_persona';
    }
}