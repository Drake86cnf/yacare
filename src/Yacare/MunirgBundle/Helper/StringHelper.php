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
     * Verifica si un decreto es mínimamente válido para su posterior procesamiento.
     * 
     * @param  string  $Decreto
     * @return boolean
     */
    public static function EsDecretoValido($Decreto)
    {
        $Decreto = str_replace(
            array('.', ',', '-', ' ', 'Nº', 'N', 'Y'), '', trim($Decreto));
        $Decreto = strtoupper(str_replace('//', '/', $Decreto));
        $BuscarNumeros = self::SepararSiglasYNumerosDecreto($Decreto);
        
        if ($BuscarNumeros == strlen($Decreto) || $Decreto{$BuscarNumeros} == '/') {
            return false;
        }
        
        $DescomponerDecreto1Nvl = array();
        $DescomponerDecreto1Nvl[0] = substr($Decreto, 0, $BuscarNumeros);
        $DescomponerDecreto1Nvl[1] = ltrim(substr($Decreto, $BuscarNumeros), '0');
        
        if ($DescomponerDecreto1Nvl[1]{0} == '/') {
            return false;
        }
        $DescomponerDecreto2Nvl = explode('/', $DescomponerDecreto1Nvl[1]);
        
        if (! $DescomponerDecreto2Nvl[1]) {
            return false;
        }
        $DescomponerDecreto3Nvl = preg_split("/[A-Z]/", $DescomponerDecreto2Nvl[1], 2);
        
        if (count($DescomponerDecreto3Nvl) == 1) {
            if (strlen($DescomponerDecreto2Nvl[1]) == 1) {
                return false;
            }
        } elseif (strlen($DescomponerDecreto3Nvl[0]) == 1) {
            return false;
        } else {
            $BuscarNumeros = self::SepararSiglasYNumerosDecreto($DescomponerDecreto3Nvl[1]);
            
            $DescomponerDecreto4Nvl = array();
            $DescomponerDecreto4Nvl[0] = substr($DescomponerDecreto3Nvl[1], 0, $BuscarNumeros);
            $DescomponerDecreto4Nvl[1] = ltrim(substr($DescomponerDecreto3Nvl[1], $BuscarNumeros), '0');
            
            if ($DescomponerDecreto4Nvl[0] && ! $DescomponerDecreto4Nvl[1]) {
                return false;
            }
            /*
             * case 'M':
             * case 'MOD':
             * case 'MODIF':
             * case 'MODIFIC':
             * case 'MODIFICACION':
             * case 'MODIFICASION':
             * $DescomponerDecreto4Nvl[0] = '';
             * break;
             * }
             */
            
            if (strlen($DescomponerDecreto4Nvl[1]) == 1) {
                return false;
            }
        }
        
        return true;
    }

    /**
     * Devuelve el decreto con formato aplicado.
     * 
     * @param  string $Decreto para procesamiento.
     * @return string $Decreto formateado.
     */
    public static function FormatearDecreto($Decreto)
    {
        $Decreto = str_replace(
            array('.', ',', '-', ' ', 'Nº', 'N', 'Y'), '', trim($Decreto));
        $Decreto = strtoupper(str_replace('//', '/', $Decreto));
        
        return StringHelper::SustituirPrefijo($Decreto);
    }

    /**
     * Normaliza los prefijos.
     * 
     * Prefijos = siglas que identifican una resolución de un decreto. 
     * Además aplica formato completo al año del mismo. 
     * 
     * @param  string $Decreto
     * @return string $Decreto minímamente formateado.
     */
    public static function SustituirPrefijo($Decreto)
    {
        $PartesDecreto = array();
        $Evaluo = self::SepararSiglasYNumerosDecreto($Decreto);
        
        $PartesDecreto[0] = substr($Decreto, 0, $Evaluo);
        $PartesDecreto[1] = ltrim(substr($Decreto, $Evaluo), '0');
        
        switch ($PartesDecreto[0]) {
            case 'RESOLUCION':
            // no break
            case 'RESOLUSION':
            case 'RESEMT':
            case 'R':
            case null:
                $PartesDecreto[0] = 'RM';
                break;
            case 'RSG':
                $PartesDecreto[0] = 'RG';
                break;
            case 'RCD':
            // no break
            case 'REOLCD':
                $PartesDecreto[0] = 'RC';
                break;
            case 'DCD':
                $PartesDecreto[0] = 'DC';
                break;
            case 'DJF':
            // no break
            case 'DTAJF':
            case 'D':
                $PartesDecreto[0] = 'DM';
                break;
            case 'A':
                $PartesDecreto[0] = 'AD';
                break;
            case 'O':
                $PartesDecreto[0] = 'OR';
                break;
        }
        
        $SubPartesDecreto = explode('/', $PartesDecreto[1]);
        
        if (strlen($SubPartesDecreto[1]) != 4) {
            if ($SubPartesDecreto[1] >= 20 && $SubPartesDecreto[1] < 100) {
                $SubPartesDecreto[1] = '19' . $SubPartesDecreto[1];
            } else {
                $SubPartesDecreto[1] = '20' . $SubPartesDecreto[1];
            }
        }
        $PartesDecreto[1] = $SubPartesDecreto[0] . '/' . $SubPartesDecreto[1];
        
        return $Decreto = $PartesDecreto[0] . $PartesDecreto[1];
    }

    /**
     * Rutina que identifica la posición de un número sobre una cadena de caracteres dada.
     * 
     * @param  string  $Decreto
     * @return integer $i       La posición del número encontrado. O la posición del final de la cadena.
     */
    public static function SepararSiglasYNumerosDecreto($Decreto)
    {
        $TieneNumeros = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
        
        for ($i = 0; $i < strlen($Decreto) && $Decreto{$i} != '/'; $i ++) {
            foreach ($TieneNumeros as $Numero) {
                if ($Decreto{$i} == $Numero) {
                    return $i;
                }
            }
        }
        return $i;
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
