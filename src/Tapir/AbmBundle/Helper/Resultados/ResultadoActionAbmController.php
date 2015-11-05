<?php
namespace Tapir\AbmBundle\Helper\Resultados;

/**
 * Describe el resultado de una acción de AbmController.
 *  
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class ResultadoActionAbmController extends \Tapir\BaseBundle\Helper\Resultados\ResultadoActionBaseController
{
    function __construct($controlador)
    {
        parent::__construct($controlador);
    }
}
