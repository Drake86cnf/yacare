<?php
namespace Yacare\ComercioBundle\Helper\Asistentes;

use Tapir\FormBundle\Asistente\Paso;

/**
 * Un asistente para iniciar un trámite de habilitacion comercial.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class BuscarTitularPaso extends Paso
{
    public function getFormType()
    {
        return new \Yacare\ComercioBundle\Form\Asistentes\BuscarTitularType();
    }
}
