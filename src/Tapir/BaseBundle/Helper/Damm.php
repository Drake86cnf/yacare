<?php
namespace Tapir\BaseBundle\Helper;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;

class Damm
{

    static function taq($digits)
    {
        $taq_table = array(
            '0317598642',
            '7092154863',
            '4206871359',
            '1750983426',
            '6123045978',
            '3674209581',
            '5869720134',
            '8945362017',
            '9438617205',
            '2581436790');
        $interim = 0;
        
        foreach (str_split($digits) as $digit) {
            if (! preg_match('~\d~', $digit))
                return FALSE;
            $interim = substr($taq_table[$interim], $digit, 1);
        }
        
        return $interim;
    }

    static public function CalcCheckDigit($digits)
    {
        return $digits . '-' . Damm::taq($digits);
    }

    static public function IsCheckDigitValid($digits)
    {
        return Damm::taq($digits) == 0;
    }
}
