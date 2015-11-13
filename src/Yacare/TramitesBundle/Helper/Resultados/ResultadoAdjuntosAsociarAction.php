<?php
namespace Yacare\TramitesBundle\Helper\Resultados;

/**
 * Describe el resultado de una acción de asociar adjuntos de una entidad.
 *  
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class ResultadoAdjuntosAsociarAction extends \Tapir\AbmBundle\Helper\Resultados\ResultadoVerAction
{
    public $Adjunto;
    
    function __construct($controlador)
    {
        parent::__construct($controlador);
    }
}
