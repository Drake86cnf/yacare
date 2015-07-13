<?php
namespace Tapir\BaseBundle\Twig;
/**
 * Clase que implementa un coversor de números a letras. 
 * 
 * @author AxiaCore S.A.S
 */
class NumerosALetras 
{
    private $UNIDADES = [
        '',
        'un ',
        'dos ',
        'tres ',
        'cuatro ',
        'cinco ',
        'seis ',
        'siete ',
        'ocho ',
        'nueve ',
        'diez ',
        'once ',
        'doce ',
        'trece ',
        'catorce ',
        'quince ',
        'dieciseis ',
        'diecisiete ',
        'dieciocho ',
        'diecinueve ',
        'veinte '
    ];
    private $DECENAS = [
        'veinti',
        'treinta ',
        'cuarenta ',
        'cincuenta ',
        'sesenta ',
        'setenta ',
        'ochenta ',
        'noventa ',
        'cien '
    ];
    private $CENTENAS = [
        'ciento ',
        'doscientos ',
        'trescientos ',
        'cuatrocientos ',
        'quinientos ',
        'seiscientos ',
        'setecientos ',
        'ochocientos ',
        'novecientos '
    ];
    private $MONEDAS = [
        ['country' => 'Argentina', 'currency' => 'ARS', 'singular' => 'peso', 'plural' => 'pesos', 'symbol', '$'],
        ['country' => 'Colombia', 'currency' => 'COP', 'singular' => 'peso colombiano', 'plural' => 'pesos colombianos', 'symbol', '$'],
        ['country' => 'Estados Unidos', 'currency' => 'USD', 'singular' => 'dólar', 'plural' => 'dólares', 'symbol', 'US$'],
        ['country' => 'Europa', 'currency' => 'EUR', 'singular' => 'euro', 'plural' => 'euros', 'symbol', '€'],
        ['country' => 'México', 'currency' => 'MXN', 'singular' => 'pexo mexicano', 'plural' => 'pesos mexicanos', 'symbol', '$'],
        ['country' => 'Perú', 'currency' => 'PEN', 'singular' => 'nuevo sol', 'plural' => 'nuevos soles', 'symbol', 'S/'],
        ['country' => 'Reino Unido', 'currency' => 'GBP', 'singular' => 'libra', 'plural' => 'libras', 'symbol', '£']
    ];
    
    
    /**
     * Convierte números a letras.
     */
    public function Convertir($number, $miMoneda = null)
    {   
        if ($miMoneda !== null) {
            try {
                
                $moneda = array_filter($this->MONEDAS, function($m) use ($miMoneda) {
                    return ($m['currency'] == $miMoneda);
                });
                $moneda = array_values($moneda);
                if (count($moneda) <= 0) {
                    throw new Exception("Tipo de moneda inválido");
                    return;
                }
                if ($number < 2) {
                    $moneda = $moneda[0]['singular'];
                } else {
                    $moneda = $moneda[0]['plural'];
                }
            } catch (Exception $e) {
                echo $e->getMessage();
                return;
            }
        } else {
            $moneda = " ";
        }
        $converted = '';
        if (($number < 0) || ($number > 999999999)) {
            return $number;
        }
        $numberStr = (string) $number;
        $numberStrFill = str_pad($numberStr, 9, '0', STR_PAD_LEFT);
        $millones = substr($numberStrFill, 0, 3);
        $miles = substr($numberStrFill, 3, 3);
        $cientos = substr($numberStrFill, 6);
        if (intval($millones) > 0) {
            if ($millones == '001') {
                $converted .= 'un millón ';
            } else if (intval($millones) > 0) {
                $converted .= sprintf('%smillones ', $this->convertGroup($millones));
            }
        }
        
        if (intval($miles) > 0) {
            if ($miles == '001') {
                $converted .= 'mil ';
            } else if (intval($miles) > 0) {
                $converted .= sprintf('%smil ', $this->convertGroup($miles));
            }
        }
        if (intval($cientos) > 0) {
            if ($cientos == '001') {
                $converted .= 'un ';
            } else if (intval($cientos) > 0) {
                $converted .= sprintf('%s ', $this->convertGroup($cientos));
            }
        }
        $converted .= $moneda;
        return $converted;
    }
    
    private function convertGroup($n)
    {
        $output = '';
        if ($n == '100') {
            $output = "cien ";
        } else if ($n[0] !== '0') {
            $output = $this->CENTENAS[$n[0] - 1];   
        }
        $k = intval(substr($n,1));
        if ($k <= 20) {
            $output .= $this->UNIDADES[$k];
        } else {
            if(($k > 30) && ($n[2] !== '0')) {
                $output .= sprintf('%sy %s', $this->DECENAS[intval($n[1]) - 2], $this->UNIDADES[intval($n[2])]);
            } else {
                $output .= sprintf('%s%s', $this->DECENAS[intval($n[1]) - 2], $this->UNIDADES[intval($n[2])]);
            }
        }
      
        return $output;
    }
}