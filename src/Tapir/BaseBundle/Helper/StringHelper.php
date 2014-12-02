<?php

namespace Tapir\BaseBundle\Helper;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;

class StringHelper
{
    
    /*
     * Obtiene el nombre del bundle y de la entidad a partide una clase. Por ejemplo, para
     * \Tapir\BaseBundle\Controller\PersonaController devuelve { "Base", "Persona" }
     */
    static public function ObtenerBundleYEntidad($nombreclase)
    {
        $PartesNombreClase = explode('\\', $nombreclase);
        
        $res = array();
        
        $res[0] = $PartesNombreClase[1];
        if (strlen($res[0]) > 6 && substr($res[0], - 6) == 'Bundle') {
            // Quitar la palabra 'Bundle' del nombre del bundle
            $res[0] = substr($res[0], 0, strlen($res[0]) - 6);
        }
        
        $res[1] = $PartesNombreClase[3];
        if (strlen($res[1]) > 10 && substr($res[1], - 10) == 'Controller') {
            // Quitar la palabra 'Controller' del nombre del controlador
            $res[1] = substr($res[1], 0, strlen($res[1]) - 10);
        }
        
        return $res;
    }
    
    
    /*
     * Obtiene el nombre la aplicación (vendor) a partir de una clase. Por ejemplo, para
     * \Tapir\BaseBundle\Controller\PersonaController devuelve "Tapir"
     */
    static public function ObtenerAplicacion($nombreclase)
    {
        $PartesNombreClase = explode('\\', $nombreclase);
        
        return $PartesNombreClase[0];
    }
    
    
    /*
     * Obtiene una ruta base a partir de una clase. Por ejemplo, para "\Tapir\BaseBundle\Controller\PersonaController"
     * devuelve "tapir_base_persona" Para ("\Tapir\BaseBundle\Controller\PersonaController", "editar") devuelve
     * "tapir_base_persona_editar".
     */
    static public function ObtenerRutaBase($nombreclase, $accion = null)
    {
        // Quito barras iniciales y finales
        $nombreclase = trim($nombreclase, '\\');
        $PartesNombreClase = StringHelper::ObtenerBundleYEntidad($nombreclase);
        
        if ($accion)
            return strtolower('yacare_' . $PartesNombreClase[0] . '_' . $PartesNombreClase[1] . '_' . $accion);
        else
            return strtolower('yacare_' . $PartesNombreClase[0] . '_' . $PartesNombreClase[1]);
    }

    
    static public function ObtenerDocumento($text)
    {
        $Partes = preg_split('/[\: ]/', $text);
        $Tipo = '';
        $Numero = '';
        
        foreach ($Partes as $Parte) {
            $v = trim($Parte);
            if ($v == '') {
                // Ignorar
            } else 
                if ($v == 'DU') {
                    $Tipo = 'DNI';
                } else 
                    if ($v == 'DU' || $v == 'SC' || $v == 'CI' || $v == 'LC' || $v == 'LE') {
                        $Tipo = $v;
                    } else {
                        $Numero = $v;
                    }
            
            if (strpos($Numero, '-')) {
                $Tipo = 'CUIL';
            } else 
                if (! $Tipo || $Tipo = 'SC') {
                    $Tipo = 'DNI';
                }
        }
        
        return array(
            $Tipo,
            ltrim($Numero, '0')
        );
    }

    
    static public function Desoraclizar($text)
    {
        return trim(StringHelper::ProperCase(StringHelper::ArreglarProblemasConocidos(StringHelper::PonerTildes($text))));
    }

    
    static public function ProperCase($string, $delimiters = array(' ', '-', '.', '"', "'", "O'", "Mc"), $exceptions = array(
                'de', 'y', 'en', 'con', 'e', 'o', 'u', '1ro.', '1ra.', '2do.', '2da.', 'del',
                'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII', 'XIII', 'XIV', 'XV', 'XVI', 'XVII', 'XVIII', 'XIX', 'XX', 'XXI', 'XXX',
                'DVD', 'ARA', 'AGP', 'YPF', 'IPV', 'CAP'
                ))
    {
        /*
         * Exceptions in lower case are words you don't want converted. Exceptions all in upper case are any words you
         * don't want converted to title case but should be converted to upper case, e.g.: king henry viii or king henry
         * Viii should be King Henry VIII
         */
        $string = mb_convert_case($string, MB_CASE_TITLE, 'UTF-8');
        
        foreach ($delimiters as $dlnr => $delimiter) {
            $words = explode($delimiter, $string);
            $newwords = array();
            foreach ($words as $wordnr => $word) {
                if (in_array(mb_strtoupper($word, 'UTF-8'), $exceptions)) {
                    // check exceptions list for any words that should be in upper case
                    $word = mb_strtoupper($word, 'UTF-8');
                } elseif (in_array(mb_strtolower($word, 'UTF-8'), $exceptions)) {
                    // check exceptions list for any words that should be in upper case
                    $word = mb_strtolower($word, 'UTF-8');
                } 

                elseif (! in_array($word, $exceptions)) {
                    // convert to uppercase (non-utf8 only)
                    $word = ucfirst($word);
                }
                array_push($newwords, $word);
            }
            $string = join($delimiter, $newwords);
        }
        
        return $string;
    }

    static public function ArreglarProblemasConocidos($text)
    {
        $text = ' ' . str_replace('  ', ' ', str_replace('.', '. ', $text)) . ' ';
        
        $remplazos = array(
            
            // Nombres de calles
            'yugoeslavia' => 'yugoslavia',
            'sra.de' => 'sra. de',
            "ernesto l'offler" => 'ernesto löffler',
            'Bernardo O¿higgins' => 'bernardo o\'higgins',
            'A. R. A. R. Rompehielos Almirante Irizar' => 'Rompehielos ARA Almirante Irízar',
            'A.R.A.R. Rompehielos Almirante Irizar' => 'Rompehielos ARA Almirante Irízar',
            'B. Frigorif.Cap Casa' => 'Barrio Frigorífico CAP Casa',
            'Cabo 1ro. J. E. Gómez' => 'Cabo 1º J. E. Gómez',
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
            'TELEFONICA DE ARGENT. S. A' => 'Telefónica de Argentina S.A.',
            'TELEFÓNICA DE ARGENT. S. A' => 'Telefónica de Argentina S.A.',
            '.' => '. ',
            'Nro.' => 'Nº',
            'N º' => 'Nº',
            'N°' => 'Nº',
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
            'Administracion' => 'Administración',
            'Direccion' => 'Dirección',
            'Coordinacion' => 'Coordinación',
            'Funcion Publica' => 'Función Pública',
            'Medico' => 'Médico',
            'Medica' => 'Médica',
            'Informatica' => 'Informática',
            'Programadoe' => 'Programador',
            'Tecnologia' => 'Tecnología',
            '' => '',
            '' => '',
            '' => '',
            '' => '',
            '' => ''
        );
        
        foreach ($remplazos as $buscar => $remplazar) {
            $text = str_ireplace(' ' . $buscar . ' ', ' ' . $remplazar . ' ', $text);
        }
        
        return trim(str_replace('  ', ' ', $text));
    }

    static public function PonerTildes($text)
    {
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
            'fabian' => 'fabián',
            'belen' => 'belén',
            'barbara' => 'bárbara',
            'estefania' => 'estefanía',
            'lucia' => 'lucía',
            'debora' => 'débora',
            'gaston' => 'gastón',
            'hernan' => 'hernán',
            'jeremias' => 'jeremías',
            'tomas' => 'tomás',
            '' => '',
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
            'narvaez' => 'narváez',
            'persico' => 'pérsico',
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
            'juridica' => 'jurídica',
            'juridicas' => 'jurídicas',
            'juridico' => 'jurídico',
            'juridicos' => 'jurídicos',
            'informatica' => 'informática',
            'tecnologia' => 'tecnología',
            '' => '',
            '' => ''
        );
        
        foreach ($remplazos as $buscar => $remplazar) {
            $text = str_ireplace(' ' . $buscar . ' ', ' ' . $remplazar . ' ', $text);
        }
        
        return trim($text);
    }
    
    
    /*
     * Obtiene el apellido y nombre de la persona por separado.
     * Devuelve un array con dos elementos (apellidos y nombre).
     * TODO: mejorar para que reconozca algunos apellidos dobles (por lista).
     */
    static public function ObtenerApellidoYNombres($nombreCompleto)
    {
        $nombreCompleto = trim(str_replace(array('.'), '', $nombreCompleto));
        $PartesNombre = explode(' ', $nombreCompleto, 2);
        
        if(count($PartesNombre) == 1) {
            $PartesNombre[] = '';
        }
    
        return $PartesNombre;
    }
    
    
    /*
     * Obtiene el nombre de la calle y la altura por separado.
     * Devuelve un array con dos o tres elementos (calle, altura [y departamento]).
     * TODO: mejorar para que si no existe 'Nº', reconozca el final del nombre de la calle cuando encuentre un dígito.
     */
    static public function ObtenerCalleYNumero($domicilio)
    {
        $domicilio = StringHelper::Desoraclizar($domicilio);
        $PartesNombre = explode('Nº', $domicilio, 2);
        
        /* if(count($PartesNombre) == 1) {
            $PartesNombre = explode(' ', $PartesNombre[0], 2);
        } */
    
        if(count($PartesNombre) == 1) {
            $PartesNombre[] = '';
        }
        
        $PartesNombre[0] = trim($PartesNombre[0]);
        $PartesNombre[1] = trim($PartesNombre[1]);
        
        $PartesNumero = explode(' ', $PartesNombre[1], 2);
        if(count($PartesNumero) == 2) {
            $PartesNombre[1] = trim($PartesNumero[0]);
            $PartesNombre[2] = trim($PartesNumero[1]);
        }

        return $PartesNombre;
    }
}

