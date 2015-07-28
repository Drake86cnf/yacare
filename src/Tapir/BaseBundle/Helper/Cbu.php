<?php
namespace Tapir\BaseBundle\Helper;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;

class Cbu
{

    static public function EsCbuValida($Cbu)
    {
        $solonumeros = str_replace(array('.', ',', ' ', '-'), '', $Cbu);
        if (strlen($solonumeros) == 22) {
    	    $digitoVerificador = $solonumeros[7];
    	    $suma = $solonumeros[0] * 7 + $solonumeros[1] * 1 + $solonumeros[2] * 3
    	    	+ $solonumeros[3] * 9 + $solonumeros[4] * 7 + $solonumeros[5] * 1 + $solonumeros[6] * 3;
    	    $diferencia = 10 - ($suma % 10);
    	     
    	    if($diferencia != $digitoVerificador) {
    	    	return false;
    	    }
    	    
    	    $digitoVerificador2 = $solonumeros[21];
    	    $suma = $solonumeros[8] * 3 + $solonumeros[9] * 9 + $solonumeros[10] * 7  + $solonumeros[11] * 1
    	    	+ $solonumeros[12] * 3 + $solonumeros[13] * 9 + $solonumeros[14] * 7 + $solonumeros[15] * 1
    	    	+ $solonumeros[16] * 3 + $solonumeros[17] * 9 + $solonumeros[18] * 7 + $solonumeros[19] * 1
    	    	+ $solonumeros[20] * 3;
    	    $diferencia = 10 - ($suma % 10);
    	    
       	    if($diferencia != $digitoVerificador2) {
    	    	return false;
    	    }
    
    	    return true;
    	}
    	return false;
    }

    static public function FormatearCbu($Cbu)
    {
        $solonumeros = str_replace(array('.', ',', ' ', '-'), '', $Cbu);
        
        if (strlen($solonumeros) == 22) {
            return substr($solonumeros, 0, 8) . '-' . substr($solonumeros, 8, 14);
        } else {
            return $Cbu;
        }
    }
}
