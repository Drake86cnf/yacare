<?php
namespace Tapir\BaseBundle\Helper;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;

class Cuilt
{

    static public function EsCuiltValido($Cuilt)
    {
        $cadena = str_replace(array('.',',',' ','-'), '', $Cuilt);
        
        $result = $cadena[0] * 5;
        $result += $cadena[1] * 4;
        $result += $cadena[2] * 3;
        $result += $cadena[3] * 2;
        $result += $cadena[4] * 7;
        $result += $cadena[5] * 6;
        $result += $cadena[6] * 5;
        $result += $cadena[7] * 4;
        $result += $cadena[8] * 3;
        $result += $cadena[9] * 2;
        
        $div = intval($result / 11);
        $resto = $result - ($div * 11);
        
        if ($resto == 0) {
            if ($resto == $cadena[10]) {
                return true;
            } else {
                return false;
            }
        } elseif ($resto == 1) {
            if ($cadena[10] == 9 and $cadena[0] == 2 and $cadena[1] == 3) {
                return true;
            } elseif ($cadena[10] == 4 and $cadena[0] == 2 and $cadena[1] == 3) {
                return true;
            }
        } elseif ($cadena[10] == (11 - $resto)) {
            return true;
        } else {
            return false;
        }
    }

    static public function FormatearCuilt($Cuilt)
    {
        $solonumeros = str_replace(array('.',',',' ','-'), '', $Cuilt);
        
        if (strlen($solonumeros) == 11) {
            return substr($solonumeros, 0, 2) . '-' . substr($solonumeros, 2, 8) . '-' . substr($solonumeros, 10, 1);
        } else {
            return $solonumeros;
        }
    }
}
