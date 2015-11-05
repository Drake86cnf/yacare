<?php
namespace Yacare\BaseBundle\Helper\Resultados;

/**
 * Describe el resultado de una acción de listar entidades.
 *  
 * @author Ezequiel Riquelme <rezequiel.tdf@gmail.com>
 */
class ResultadoVerActionDispositivoGps extends \Tapir\AbmBundle\Helper\Resultados\ResultadoVerAction
{
    public $UltimoRastreo, $map, $js, $id, $uno, $Dispositivos;
    
    function __construct($controlador)
    {
        parent::__construct($controlador);
    }
}
