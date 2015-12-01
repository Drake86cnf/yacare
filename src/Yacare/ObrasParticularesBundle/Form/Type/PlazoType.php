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
                '1' => '1 día',
                '5' => '5 días',
                '10' => '10 días',
                '30' => '30 días',
                '60' => '60 días',
                '90' => '90 días')
            ));
    }

    public function getParent()
    {
        return 'Symfony\Component\Form\Extension\Core\Type\ChoiceType';
    }
}
