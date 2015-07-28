<?php
namespace Tapir\BaseBundle\Helper;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;

class Cbu
{
    public static $Bancos = [
        5 => "ABN AMRO Bank",
        7 => "Banco Galicia",
        10 => "Lloyds TSB Bank plc",
        11 => "Banco de la Nación Argentina",
        14 => "Banco de la Provincia de Buenos Aires",
        15 => "Standard Bank Argentina",
        16 => "Citibank N.A.",
        17 => "BBVA Banco Francés",
        18 => "The Bank of Tokyo - Mitsubishi,  Ltd.",
        20 => "Banco de la Provincia de Córdoba",
        27 => "Banco Supervielle",
        29 => "Banco de la Ciudad de Buenos Aires",
        34 => "Banco Patagonia Sudameris",
        44 => "Banco Hipotecario",
        45 => "Banco de San Juan",
        46 => "Banco do Brasil",
        60 => "Banco del Tucumán",
        65 => "Banco Municipal de Rosario",
        72 => "Banco Santander Río",
        79 => "Banco Regional de Cuyo",
        83 => "Banco del Chubut",
        86 => "Banco de Santa Cruz",
        93 => "Banco de La Pampa Sociedad de Economia Mixta",
        94 => "Banco de Corrientes",
        97 => "Banco Provincia del Neuquén",
        137 => "Banco Empresario de Tucumán Coop. Ltdo.",
        147 => "Banco B. I. Creditanstalt",
        150 => "HSBC Bank Argentina",
        165 => "J P Morgan Chase Bank Sucursal Buenos Aires",
        191 => "Banco Credicoop Coop. Ltdo.",
        198 => "Banco de Valores",
        247 => "Banco Roela",
        254 => "Banco Mariva",
        259 => "Banco Itaú Buen Ayre",
        262 => "Bank of America, National Association",
        265 => "Banca Nazionale del Lavoro",
        266 => "BNP Paribas",
        268 => "Banco Provincia de Tierra del Fuego",
        269 => "Banco de la Republica Oriental del Uruguay",
        277 => "Banco Saenz",
        281 => "Banco Meridian",
        285 => "Banco Macro Bansud",
        293 => "Banco Mercurio",
        294 => "ING Bank N.V.",
        295 => "American Express Bank Ltd.",
        297 => "Banco Banex",
        299 => "Banco Comafi",
        300 => "Banco de Inversión y Comercio Exterior",
        301 => "Banco Piano",
        303 => "Banco Finansur",
        305 => "Banco Julio",
        306 => "Banco Privado de Inversiones",
        309 => "Nuevo Banco de La Rioja",
        310 => "Banco del Sol",
        311 => "Nuevo Banco del Chaco",
        312 => "M. B. A. Banco de Inversiones",
        315 => "Banco de Formosa",
        319 => "Banco CMF",
        321 => "Banco de Santiago del Estero",
        322 => "Nuevo Banco Industrial de Azul",
        325 => "Deutsche Bank",
        330 => "Nuevo Banco de Santa Fe",
        331 => "Banco Cetelem Argentina",
        332 => "Banco de Servicios Financieros",
        335 => "Banco Cofidis",
        336 => "Banco Bradesco Argentina",
        338 => "Banco de Servicios y Transacciones",
        339 => "RCI Banque",
        340 => "BACS Banco de Credito y Securitizacion",
        341 => "Banco Masventas",
        386 => "Nuevo Banco de Entre Rios",
        387 => "Nuevo Banco Suquia",
        388 => "Nuevo Banco Bisel",
        389 => "Banco Columbia"
    ];

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
