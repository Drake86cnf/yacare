<?php
namespace Yacare\RecursosHumanosBundle\Helper;

/**
 * Funciones para cálculo de antigüedades de agentes municipales.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class Antiguedades {
    public static function CalcularAntiguedadHaberes($desdefecha, $hastafecha = null) {
        if($hastafecha == null) {
            $hastafecha = new \DateTime();
        }
        
        $Diff = $desdefecha->diff($hastafecha);

        return $Diff;
    }
    
    public static function CalcularAntiguedadJubilacionProvincial($desdefecha, $hastafecha = null) {
        if($hastafecha == null) {
            $hastafecha = new \DateTime();
        }
    
        $Diff = $desdefecha->diff($hastafecha);
    
        return $Diff;
    }
}