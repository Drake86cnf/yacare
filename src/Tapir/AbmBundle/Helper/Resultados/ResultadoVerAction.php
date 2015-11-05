<?php
namespace Tapir\AbmBundle\Helper\Resultados;

/**
 * Describe el resultado de una acción de listar entidades.
 *  
 * @author Ezequiel Riquelme <rezequiel.tdf@gmail.com>
 */
class ResultadoVerAction extends ResultadoActionAbmController
{
    public $Entidad;
    
    function __construct($controlador)
    {
        parent::__construct($controlador);
    }
}
