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
    public $Filtros;
    
    function __construct($controlador)
    {
    	$this->Filtros = array();
        parent::__construct($controlador);
    }
}
