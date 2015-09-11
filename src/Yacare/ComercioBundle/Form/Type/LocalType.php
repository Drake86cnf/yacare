<?php
namespace Yacare\ComercioBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Campo de formulario para seleccionar una local comercial.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class LocalType extends AbstractType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired(array('class'));
        $resolver->setDefaults(
            array(
                'placeholder' => 'Seleccione un local',
                'class' => 'Yacare\ComercioBundle\Entity\Local'
            ));
    }

    public function getParent()
    {
        return 'tapir_ajax_entity';
    }

    public function getName()
    {
        return 'yacare_comercio_local';
    }
}