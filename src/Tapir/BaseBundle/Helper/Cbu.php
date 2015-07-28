<?php
namespace Tapir\BaseBundle\Helper;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;

class Cbu
{

    static public function EsCbuValida($Cbu)
    {
        $solonumeros = str_replace(array('.', ',', ' ', '-'), '', $Cbu);
        return strlen($solonumeros) == 22;
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
