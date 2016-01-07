<?php
namespace Yacare\BaseBundle\Form\Type;

use Symfony\Component\Form\AbstractType;

/**
 * Campo de formulario para indicar si requiere atención.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class RequiereAtencionType extends AbstractType
{
    public function getParent()
    {
        return 'Symfony\Component\Form\Extension\Core\Type\ChoiceType';
    }
}
