<?php
namespace Yacare\MunirgBundle\StringHelper;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;

class StringHelper
{

    
    static public function ArreglarDecretos($Decreto)
    {
        $Decreto = str_replace(array(
            '.',
            ',',
            '-',
            ' ',
            'Nº',
            'N',
            'Y'), '', trim($Decreto));
        $Decreto = str_replace('//', '/', $Decreto);
        
        return StringHelper::SustituirPrefijos($Decreto);
    }

    static public function SustituirPrefijos($Decreto)
    {
        $PartesDecreto = array();
        
        $PartesDecreto[0] = substr($Decreto, 0, \Tapir\BaseBundle\Helper\StringHelper::IdentificarSiglasDecreto($Decreto));
        $PartesDecreto[1] = substr($Decreto, \Tapir\BaseBundle\Helper\StringHelper::IdentificarSiglasDecreto($Decreto));
        
        switch ($PartesDecreto[0]) {
            case 'RESOLUCION':
            case 'RESOLUSION':
            case 'RES EMT':
            case 'R':
            case null:
                $PartesDecreto[0] = 'RM';
                break;
            case 'RCD':
            case 'REOLCD':
                $PartesDecreto[0] = 'RC';
                break;
            case 'DCD':
                $PartesDecreto[0] = 'DC';
                break;
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

    static public function DecifrarCategoriasAcargo($Acargo, $Categoria)
    {
        $Aguja = 'A/C';
        $CategoriaN = null;
        $EncontreDosDigitos=true;
        $Devolver=array('Bandera'=>$EncontreDosDigitos,'categoria_nueva'=>$CategoriaN);
        if (strlen($Acargo >= 3)) {
            $Resultado = strpos($Acargo, $Aguja);
            if ($Resultado) {
                for ($i = 0; $i < strlen($Acargo); $i ++) {
                    if (is_int($Acargo{i})) {
                        if (is_int($Acargo{i + 1})) {
                            $CategoriaN = $Acargo{i} . $Acargo{i+1};
                            $EncontreDosDigitos=true;
                            break;
                        }
                    }
                }
                if($CategoriaN>=10 && $CategoriaN<=24){
                    if ($CategoriaN>$Categoria){
                        return $Devolver;
                    }
                
                     
                }
            }
            
        }
        else {
            $Devolver[0]=false;
            return $Devolver;
        }
        
        
    }
    

    static public function IdentificarSiglasDecreto($Decreto)
{
    $Numeros = array(
        '0',
        '1',
        '2',
        '3',
        '4',
        '5',
        '6',
        '7',
        '8',
        '9');
    
    for ($i = 0; $i < strlen($Decreto); $i ++) {
        foreach ($Numeros as $Numero) {
            if ($Decreto{$i} == $Numero) {
                return $i;
            }
        }
    }
}
}