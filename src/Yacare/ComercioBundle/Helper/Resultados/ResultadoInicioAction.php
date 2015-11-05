<?php
namespace Yacare\ComercioBundle\Helper\Resultados;

/**
 * Describe el resultado de la acción de inicio de comercio.
 *  
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class ResultadoInicioAction extends \Tapir\AbmBundle\Helper\Resultados\ResultadoInicioAction
{
    function __construct($controlador)
    {
        parent::__construct($controlador);
    }
    
    public $Tramites, $Comercios, $Locales;
}