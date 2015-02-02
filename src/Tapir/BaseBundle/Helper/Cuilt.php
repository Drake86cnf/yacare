<?php
namespace Tapir\BaseBundle\Helper;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;

class Cuilt
{
    static public function EsCuiltValido($cuilt) {
        // TODO: validar el CUIT
        return true;
    }
    
    static public function FormatearCuilt($Cuilt) {
        $solonumeros = str_replace(array ( '.', ',', ' ', '-' ), '', $Cuilt);
        
        if(strlen($solonumeros) == 11) {
            return substr($solonumeros, 0, 2) . '-' . substr($solonumeros, 2, 8) . '-' . substr($solonumeros, 10, 1);
        } else {
            return $solonumeros;
        }
    }
    
}
