<?php

namespace Yacare\BaseBundle\Helper;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;

class StringHelper {
    
    static public function ObtenerDocumento($text) {
        $Partes = preg_split('/[\: ]/', $text);
        $Tipo = '';
        $Numero = '';

        foreach($Partes as $Parte) {
            $v = trim($Parte);
            if($v == '') {
                // Ignorar
            } else if($v == 'DU') {
                $Tipo = 'DNI';
            } else if($v == 'DU'  || $v == 'SC' || $v == 'CI' || $v == 'LC' || $v == 'LE') {
                $Tipo = $v;
            } else {
                $Numero = $v;
            }
            
            if(strpos($Numero, '-'))
                $Tipo = 'CUIL';
            else if(!$Tipo || $Tipo = 'SC')
                $Tipo = 'DNI';
        }

        return array($Tipo, ltrim($Numero, '0'));
    }

    
    static public function Desoraclizar($text) {
        return StringHelper::ProperCase(StringHelper::ArreglarProblemasConocidos(StringHelper::PonerTildes($text)));
    }
    
    static public function ProperCase($string, 
            $delimiters = array(' ', '-', '.', '"', "'", "O'", "Mc"),
            $exceptions = array(
                'de', 'y', 'e', 'o', 'u', '1ro.', '1ra.', '2do.', '2da.', 'del',
                'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII', 'XIII', 'XIV', 'XV', 'XVI', 'XVII', 'XVIII', 'XIX', 'XX', 'XXI', 'XXX',
                'DVD', 'ARA', 'AGP', 'YPF', 'IPV', 'CAP'
                )) {
        /*
         * Exceptions in lower case are words you don't want converted.
         * Exceptions all in upper case are any words you don't want converted to title case
         *   but should be converted to upper case, e.g.:
         *   king henry viii or king henry Viii should be King Henry VIII
         */
        $string = mb_convert_case($string, MB_CASE_TITLE, 'UTF-8');

        foreach ($delimiters as $dlnr => $delimiter){
                $words = explode($delimiter, $string);
                $newwords = array();
                foreach ($words as $wordnr => $word){
                        if (in_array(mb_strtoupper($word, 'UTF-8'), $exceptions)) {
                                // check exceptions list for any words that should be in upper case
                                $word = mb_strtoupper($word, 'UTF-8');
                        }
                        elseif (in_array(mb_strtolower($word, 'UTF-8'), $exceptions)) {
                                // check exceptions list for any words that should be in upper case
                                $word = mb_strtolower($word, 'UTF-8');
                        }

                        elseif (!in_array($word, $exceptions)) {
                                // convert to uppercase (non-utf8 only)
                                $word = ucfirst($word);
                        }
                        array_push($newwords, $word);
                }
                $string = join($delimiter, $newwords);
        }

        return $string;
    }
    
    
    static public function ArreglarProblemasConocidos($text) {
        $text = ' ' . str_replace('  ', ' ', str_replace('.', '. ', $text)) . ' ';
        
        $remplazos = array(
            // Nombres de calles
            'yugoeslavia' => 'yugoslavia',
            'sra.de' => 'sra. de',
            "ernesto l'offler" => 'ernesto löffler',
            'Bernardo O¿higgins' => 'bernardo o\'higgins',
            'A.R.A.R. Rompehielos Almirante Irizar' => 'Rompehielos ARA Almirante Irízar',
            'B. Frigorif.Cap Casa' => 'Barrio Frigorífico CAP Casa',
            'Cabo 1ro. J.E. Gómez' => 'Cabo 1º J. E. Gómez',
            'B. Aeroposta Casa' => 'Barrio Aeroposta Casa',
            'Doctor Ricardo Balbín' => 'Dr. Ricardo Balbín',
            'Doctor René Favaloro' => 'Dr. René Favaloro',
            'Doctor Roberto Koch' => 'Dr. Roberto Koch',
            'Doctor Rodolfo Rivarola' => 'Dr. Rodolfo Rivarola',
            'Doctor Alejandro Fleming' => 'Dr. Alejandro Fleming',
            'Doctor Raúl Chifflet' => 'Dr. Raúl Chifflet',
            'Doctor Leandro N. Alem' => 'Dr. Leandro N. Alem',
            'Doctor Carlos Alfredo Pacheco' => 'Dr. Carlos Alfredo Pacheco',
            'Juan Bautistade La Salle' => 'Juan Bautista de La Salle',
            'Willian Alfredo Bishop' => 'William Alfredo Bishop',
            'María Agdalena Macacha Guemez' => 'María Magdalena "Macacha" Güemes',
            'Womska' => 'Wonska',
            'TELEFONICA DE ARGENT. S.A' => 'Telefónica de Argentina S.A.',
            '.' => '. ',
            'Nro.' => 'Nº',
            'S. A. G. C.' => 'S.A.G.C.',
            'S. A.' => 'S.A.',
            'S. R. L.' => 'S.R.L.',
            'A. F. I. P.' => 'A.F.I.P.',
            'U. O. C. R. A.' => 'U.O.C.R.A.',
            'I. N. T. A.' => 'I.N.T.A.',
            'Q. R. U.' => 'Q.R.U.',
            'I. P. V.' => 'I.P.V.',
            'R. Gde.' => 'Río Grande',
            'O. S. N.' => 'O.S.N.',
            'I. S. S. T.' => 'I.S.S.T.',
            'A. S. I. M. R. A.' => 'A.S.I.M.R.A.',
            'Srl' => 'S.R.L.',
            'Esc. N 8' => 'Esc. Nº 8',
            'y Cia. Sa' => 'y Cía. S.A.',
            '' => '',
            '' => '',
            '' => '',
            );
        
        foreach ($remplazos as $buscar => $remplazar) {
            $text = str_ireplace(' ' . $buscar . ' ', ' ' . $remplazar . ' ', $text);
        }
        
        return trim(str_replace('  ', ' ', $text));
    }
    

    static public function PonerTildes($text) {
        $text = ' ' . $text . ' ';
        
        $remplazos = array(
            // Nombres propios
            'saenz pena' => 'sáenz peña',
            'cristobal colon' => 'cristobal colón',
            'tucuman' => 'tucumán',
            'general guemes' => 'general güemes',
            'mamerto esquiu' => 'mamerto esquiú',
            'maipu' => 'maipú',
            'ceferino namuncura' => 'ceferino namuncurá',
            'neuquen' => 'neuquén',
            'panama' => 'panamá',
            'peru' => 'perú',
            'lujan' => 'luján',
            'cordoba' => 'córdoba',
            '.' => '',
            'angeles' => 'ángeles',
            '' => '',
            '' => '',
            '' => '',
            // Nombres
            'martin' => 'martín',
            'maria' => 'maría',
            'jose' => 'josé',
            'nicolas' => 'nicolás',
            'angel' => 'ángel',
            'angela' => 'ángela',
            'teofilo' => 'teófilo',
            'felix' => 'félix',
            'hector' => 'héctor',
            'sebastian' => 'sebastián',
            'ines' => 'inés',
            'ramon' => 'ramón',
            'agustin' => 'agustín',
            'nestor' => 'néstor',
            'victor' => 'víctor',
            'itati' => 'itatí',
            'rene' => 'rené',
            'raul' => 'raúl',
            'hipolito' => 'hipólito',
            'simon' => 'simón',
            'jeronimo' => 'jerónimo',
            'maximo' => 'máximo',
            'joaquin' => 'joaquín',
            'jesus' => 'jesús',
            'cesar' => 'césar',
            'adrian' => 'adrián',
            'jesica' => 'jésica',
            'andres' => 'andrés',
            'veronica' => 'verónica',
            'nelida' => 'nélida',
            'noemi' => 'noemí',
            'matias' => 'matías',
            '' => '',
            '' => '',
            // Apellidos
            'perez' => 'pérez',
            'hernandez' => 'hernández',
            'fernandez' => 'fernández',
            'vazques' => 'vázques',
            'vazquez' => 'vázquez',
            'vasquez' => 'vásquez',
            'martinez' => 'martínez',
            'saenz' => 'sáenz',
            'albarracin' => 'albarracín',
            'balbin' => 'balbín',
            'rodriguez' => 'rodríguez',
            'ramirez' => 'ramírez',
            'gonzalez' => 'gonzález',
            'gomez' => 'gómez',
            'saldias' => 'saldías',
            'santome' => 'santomé',
            'lopez' => 'lópez',
            'bolivar' => 'bolívar',
            'chavez' => 'chávez',
            'chaves' => 'cháves',
            'sanchez' => 'sánchez',
            'benitez' => 'benítez',
            'echeverria' => 'echeverría',
            'peron' => 'perón',
            'garcia' => 'garcía',
            'anadon' => 'anadón',
            'juarez' => 'juárez',
            'cortazar' => 'cortázar',
            'galvez' => 'gálvez',
            'azcuenaga' => 'azcuénaga',
            'barria' => 'barría',
            'chacon' => 'chacón',
            'alvarez' => 'álvarez',
            'carcamo' => 'cárcamo',
            'loffler' => 'löffler',
            'monaco' => 'mónaco',
            'mu;oz' => 'muñoz',
            'avila' => 'ávila',
            'oyarzun' => 'oyarzún',
            'marquez' => 'márquez',
            'velez' => 'vélez',
            'almiron' => 'almirón',
            'gimenez' => 'giménez',
            'jimenez' => 'jiménez',
            'suarez' => 'suárez',
            'roldan' => 'roldán',
            'monzon' => 'monzón',
            'cardenas' => 'cárdenas',
            'mejias' => 'mejías',
            'diaz' => 'díaz',
            'dias' => 'días',
            'rios' => 'ríos',
            'paez' => 'páez',
            'mendez' => 'méndez',
            'nuñez' => 'núñez',
            '' => '',
            '' => '',
            // Otras palabras
            'antartida' => 'antártida',
            'antartica' => 'antártica',
            'antartico' => 'antártico',
            'artica' => 'ártica',
            'artico' => 'ártico',
            'patagonico' => 'patagónico',
            'patagonica' => 'patagónica',
            'gaviotin' => 'gaviotín',
            'condor' => 'cóndor',
            'aguila' => 'águila',
            'halcon' => 'halcón',
            'rio' => 'río',
            'mision' => 'misión',
            'espiritu' => 'espíritu',
            'paramo' => 'páramo',
            'maiten' => 'maitén',
            'guarani' => 'guaraní',
            'alferez' => 'alférez',
            'policia' => 'policía',
            'educacion' => 'educación',
            'peninsula' => 'península',
            'heroes' => 'héroes',
            'comun' => 'común',
            'cauquen' => 'cauquén',
            'asociacion' => 'asociación',
            'telefonica' => 'telefónica',
            '' => '',
            '' => '',
            '' => '',
            '' => '',
            );
        
        foreach ($remplazos as $buscar => $remplazar) {
            $text = str_ireplace(' ' . $buscar . ' ', ' ' . $remplazar . ' ', $text);
        }
        
        return trim($text);
    }
}

