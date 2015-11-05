<?php

namespace Tapir\BaseBundle\Helper\Resultados;

/**
 * Describe el resultado de una acción de un controlador.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class ResultadoAction {
    public $Controlador;
    
    function __construct($controlador) {
        $this->Controlador = $controlador;
    }
}