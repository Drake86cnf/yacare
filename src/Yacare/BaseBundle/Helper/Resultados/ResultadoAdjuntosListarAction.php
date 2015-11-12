<?php
namespace Yacare\BaseBundle\Helper\Resultados;

/**
 * Describe el resultado de una acción de listar adjuntos de una entidad.
 *  
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class ResultadoAdjuntosListarAction extends \Tapir\AbmBundle\Helper\Resultados\ResultadoListarAction
{
    public $Entidad, $EntidadTipo, $EntidadId;
    public $FormularioSubir;
    
    function __construct($controlador)
    {
        parent::__construct($controlador);
    }
}
