<?php
namespace Tapir\BaseBundle\Helper\Resultados;

/**
 * Describe el resultado de una acción de un controlador.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
abstract class ResultadoAction
{
    public $Controlador;
    public $Container;

    function __construct($controlador)
    {
        $this->Controlador = $controlador;
        $this->Container = $controlador->getContainer();
    }
}
