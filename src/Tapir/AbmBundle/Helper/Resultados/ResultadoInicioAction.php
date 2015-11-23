<?php
namespace Tapir\AbmBundle\Helper\Resultados;

/**
 * Describe el resultado de una acción de inicio.
 *  
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class ResultadoInicioAction extends ResultadoActionAbmController
{
    public $Contadores = array();
    
    function __construct($controlador)
    {
        parent::__construct($controlador);
    }
}