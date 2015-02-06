<?php

namespace Tapir\BaseBundle\Twig;

use Twig_Extension;
use Twig_Filter_Method;
use Twig_Function_Method;
use Symfony\Component\Form\Extension\Core\DataTransformer\DateTimeToStringTransformer;
use Symfony\Component\Form\Extension\Core\DataTransformer\DateTimeToTimestampTransformer;

class TapirExtension extends \Twig_Extension {
    public function getFilters() {
        return array (
                new \Twig_SimpleFilter ( 'tapir_cuiltesvalida', array (
                        $this,
                        'tapir_cuiltesvalida'
                ) )
        );
    }
    public function tapir_cuiltesvalida($Cuilt) {
        $CuiltSaneado = str_split ( str_replace ( '-', '', trim ( $Cuilt ) ) );

        if (count ( $CuiltSaneado ) != 11) {
            return false;
        }

        $result = $CuiltSaneado [0] * 5;
        $result += $CuiltSaneado [1] * 4;
        $result += $CuiltSaneado [2] * 3;
        $result += $CuiltSaneado [3] * 2;
        $result += $CuiltSaneado [4] * 7;
        $result += $CuiltSaneado [5] * 6;
        $result += $CuiltSaneado [6] * 5;
        $result += $CuiltSaneado [7] * 4;
        $result += $CuiltSaneado [8] * 3;
        $result += $CuiltSaneado [9] * 2;

        $div = intval ( $result / 11 );
        $resto = $result - ($div * 11);

        if ($resto == 0) {
            if ($resto == $CuiltSaneado [10]) {
                return true;
            } else {
                return false;
            }
        } elseif ($resto == 1) {
            if ($CuiltSaneado [10] == 9 and $CuiltSaneado [0] == 2 and $CuiltSaneado [1] == 3) {
                return true;
            } elseif ($CuiltSaneado [10] == 4 and $CuiltSaneado [0] == 2 and $CuiltSaneado [1] == 3) {
                return true;
            }
        } elseif ($CuiltSaneado [10] == (11 - $resto)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName() {
        return 'tapir_extension';
    }
}
