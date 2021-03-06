<?php
namespace Tapir\BaseBundle\Helper;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;

/**
 * Clase con métodos útiles para Cuilt.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class Cuilt
{
    /**
     * Evalúa si un cuilt obedece un formato y largo de cadena válido.
     * 
     * @param  string $Cuilt
     * @return boolean
     */
    public static function EsCuiltValida($Cuilt)
    {
        $cadena = str_replace(array('.', ',', ' ', '-'), '', $Cuilt);
        
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

    /**
     * Devuelve un cuilt formateado.
     * 
     * Elimina cualquier otro caracter que no sea números (para asegurarse que, por ejemplo, ningún guión '-' se
     * encuentre fuera de lugar. Y devuelve la cadena bajo el formato: XX-XXXXXXXX-X.
     * 
     * @param  string $Cuilt
     * @return string
     */
    public static function FormatearCuilt($Cuilt)
    {
        $solonumeros = str_replace(array('.', ',', ' ', '-'), '', $Cuilt);
        
        if (strlen($solonumeros) == 11) {
            return substr($solonumeros, 0, 2) . '-' . substr($solonumeros, 2, 8) . '-' . substr($solonumeros, 10, 1);
        } else {
            return $Cuilt;
        }
    }
}
