<?php
namespace Tapir\BaseBundle\Controller;

use Symfony\Component\HttpFoundation\Request;

/**
 * Agrega la capacidad de tener uno o más conjuntos de acciones relacionadas.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
trait ConAcciones
{
    protected $Actions = array();

    public function ObtenerAcciones($conjunto = '1')
    {
        if (array_key_exists($conjunto, $this->Actions)) {
            return $this->Actions[$conjunto];
        } else {
            $NuevoConjunto = new \Tapir\TemplateBundle\Controls\ActionSet();
            $this->Actions[$conjunto] = $NuevoConjunto;
            return $NuevoConjunto;
        }
    }
}
