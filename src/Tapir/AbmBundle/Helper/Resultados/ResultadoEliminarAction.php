<?php
namespace Tapir\AbmBundle\Helper\Resultados;

/**
 * Describe el resultado de una acción Ver entidad.
 *  
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class ResultadoEliminarAction extends ResultadoActionAbmController
{
    public $Entidad, $FormularioEliminar, $Relaciones;
    
    function __construct($controlador)
    {
        parent::__construct($controlador);
    }
}
