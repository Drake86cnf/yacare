<?php
namespace Yacare\RecursosHumanosBundle\Helper;

/**
 * Funciones para cálculo de antigüedades de agentes municipales.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class Antiguedades
{
    /**
     * Calcula antigüedad de haberes.
     * 
     * @param  \DateTime     $desdefecha
     * @param  \DateTime     $hastafecha
     * @return \DateInterval
     */
    public static function CalcularAntiguedadHaberes($desdefecha, $hastafecha = null)
    {
        if ($hastafecha == null) {
            $hastafecha = new \DateTime();
        }
        
        $Diff = $desdefecha->diff($hastafecha);
        
        return $Diff;
    }

    /**
     * Calcula antigüedad de jubilación provincial.
     * 
     * @param  \DateTime     $desdefecha
     * @param  \DateTime     $hastafecha
     * @return \DateInterval
     */
    public static function CalcularAntiguedadJubilacionProvincial($desdefecha, $hastafecha = null)
    {
        if ($hastafecha == null) {
            $hastafecha = new \DateTime();
        }
        
        $Diff = $desdefecha->diff($hastafecha);
        
        return $Diff;
    }
}
