<?php
namespace Yacare\MunirgBundle\Helper;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;

/**
 * Clase que soluciona problemas conocidos sobre distintas cadenas de texto.
 * 
 * @author Ezequiel Riquelme <rezequiel.tdf@gmail.com>
 * @author Alejandro Díaz <adiaz.rc@gmail.com>
 */
class StringHelper
{
    /**
     * Formatea un acto adminitrativo con estilo "RM-123/2014".
     */
    public static function FormatearActoAdministrativo($numeroActo)
    {
        $numeroActo = str_replace(array('.', ',', '-', ' ', 'Nº', 'N', 'Y'), '', trim($numeroActo));
        $numeroActo = strtoupper(str_replace('//', '/', $numeroActo));
        
        $NumeroActo = strpbrk($numeroActo, '0123456789/');
        $TipoActo = strtoupper(substr($numeroActo, 0, strlen($numeroActo) - strlen($NumeroActo)));
        
        switch ($TipoActo) {
            case 'RESOLUCION':
                // no break
            case 'RESOLUSION':
                // no break
            case 'RESEMT':
                // no break
            case 'R':
                $TipoActo = 'RM';
                break;
            case 'REOLCD':
                $TipoActo = 'RCD';
                break;
            case 'D':
                $TipoActo = 'DM';
                break;
        }
        
        $PartesNumero = explode('/', $NumeroActo, 2);
        
        if(count($PartesNumero) == 2) {
            if (strlen($PartesNumero[1]) != 4) {
                if ($PartesNumero[1] >= 20 && $PartesNumero[1] < 100) {
                    $PartesNumero[1] = '19' . $PartesNumero[1];
                } else {
                    $PartesNumero[1] = '20' . $PartesNumero[1];
                }
            }
            $NumeroActo = ltrim($PartesNumero[0], '0') . '/' . $PartesNumero[1];
        }
        
        if($TipoActo && $NumeroActo) {
            $numeroActo = $TipoActo . '-' . $NumeroActo;
        } elseif($NumeroActo) {
            $numeroActo = $NumeroActo;
        } else {
            $numeroActo = '';
        }
        
        return $numeroActo;
    }


    /**
     * Formateo de la columna de categoría A/C de un agente municipal.
     * 
     * @param string $Acargo
     * @param string $Categoria
     */
    public static function DescifrarCategoriasAcargo($Acargo, $Categoria)
    {
        $Aguja = 'A/C';
        $CategoriaN = null;
        $flag = true;
        $Devolver = array('Bandera' => $flag, 'categoria_nueva' => $CategoriaN);
        if (strlen($Acargo >= 3)) {
            $Resultado = strpos($Acargo, $Aguja);
            if ($Resultado) {
                for ($i = 0; $i < strlen($Acargo); $i ++) {
                    if (is_int($Acargo{i})) {
                        if (is_int($Acargo{i + 1})) {
                            $CategoriaN = $Acargo{i} . $Acargo{i + 1};
                            $flag = true;
                            break;
                        }
                    }
                }
                if ($CategoriaN >= 10 && $CategoriaN <= 24) {
                    if ($CategoriaN > $Categoria) {
                        return $Devolver;
                    }
                }
            }
        } else {
            $Devolver[0] = false;
            
            return $Devolver;
        }
    }
}
