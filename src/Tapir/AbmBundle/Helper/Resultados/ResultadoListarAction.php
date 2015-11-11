<?php
namespace Tapir\AbmBundle\Helper\Resultados;

/**
 * Describe el resultado de una acción de listar entidades.
 *  
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class ResultadoListarAction extends ResultadoActionAbmController
{
    public $Entidades;
    
    function __construct($controlador)
    {
        parent::__construct($controlador);
    }
}
