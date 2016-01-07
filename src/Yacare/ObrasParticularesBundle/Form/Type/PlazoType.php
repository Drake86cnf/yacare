<?php
namespace Yacare\ObrasParticularesBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Campo de formulario para ingreso plazo en actas de Obras Particulares.
 *
 * @author Ezequiel Riquelme <rezequiel.tdf@gmail.com>
 */
class PlazoType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'choices' => array(
                '1 día' => 1,
                '5 días' => 5,
                '10 días' => 10,
                '30 días' => 30,
                '60 días' => 60,
                '90 días' => 90)));
    }

    public function getParent()
    {
        return 'Symfony\Component\Form\Extension\Core\Type\ChoiceType';
    }
}
