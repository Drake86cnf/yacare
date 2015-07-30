<?php
namespace Tapir\BaseBundle\Twig;

use Twig_Extension;
use Twig_Filter_Method;
use Twig_Function_Method;
use Symfony\Component\Form\Extension\Core\DataTransformer\DateTimeToStringTransformer;
use Symfony\Component\Form\Extension\Core\DataTransformer\DateTimeToTimestampTransformer;
use Tapir;

class FormatExtension extends \Twig_Extension
{

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('tapir_hacetiempo', array(
                $this,
                'tapir_hacetiempo'
            )),
            new \Twig_SimpleFilter('tapir_diferenciafechas', array(
                $this,
                'tapir_diferenciafechas'
            )),
            new \Twig_SimpleFilter('tapir_cantidaddedias', array(
                $this,
                'tapir_cantidaddedias'
            )),
            new \Twig_SimpleFilter('tapir_sino', array(
                $this,
                'tapir_sino'
            )),
            new \Twig_SimpleFilter('tapir_numerosaletras', array(
                $this,
                'tapir_numerosaletras'
            )),
            new \Twig_SimpleFilter('tapir_mejorartexto', array(
                $this,
                'tapir_mejorartexto'
            )),
            new \Twig_SimpleFilter('tapir_fecha', array(
                $this,
                'tapir_fecha'
            )),
            new \Twig_SimpleFilter('tapir_importe', array(
                $this,
                'tapir_importe'
            )),
        	new \Twig_SimpleFilter('tapir_porcentaje', array(
        			$this,
        			'tapir_porcentaje'
        	)),
            new \Twig_SimpleFilter('tapir_decodehtml', array(
                $this,
                'tapir_decodehtml'
            )),
            new \Twig_SimpleFilter('tapir_abreviar', array(
                $this,
                'tapir_abreviar'
            ))
        );
    }
    
    public function tapir_diferenciafechas($diff) {
        $partes = array();
        if($diff->y == 1) {
                $partes[] = $diff->y . ' año'; 
        } elseif($diff->y > 1) {
                $partes[] = $diff->y . ' años'; 
        }
        
        if($diff->m == 1) {
            $partes[] = $diff->m . ' mes';
        } elseif($diff->m > 1) {
            $partes[] = $diff->m . ' meses';
        }
        
        if($diff->d == 1) {
            $partes[] = $diff->d . ' día';
        } elseif($diff->d > 1) {
            $partes[] = $diff->d . ' días';
        }
        
        return implode($partes, ', ');
    }


    public function tapir_porcentaje($number, $decimales = 0, $option = '%')
    {
        if ($number == null) {
            return '';
        } elseif (! is_numeric($number)) {
            $number = $number + 0;
        }

    	if (strpos($option, '-') !== false && $number == 0) {
    		return '-';
    	} else {
    		if ($number) {
    			$price = number_format($number, $decimales, ',', ' ');
    			// $price = $price;
    			if(strpos($option, '%') !== false) {
                	return $price . '%';
                } else {
                	return $price;
                }
    		} else {
    			if(strpos($option, '%') !== false) {
    				return $number . '%';
    			} else {
    				return $number;
    			}
    		}
    	}
    }


    public function tapir_importe($number, $option = '')
    {
        if ($number == null) {
            return '';
        } elseif (! is_numeric($number)) {
            $number = $number + 0;
        }

        if (strpos($option, '-') !== false && $number == 0) {
            return '-';
        } else {
            if ($number) {
                $price = number_format($number, 2, ',', ' ');
                // $price = $price;
                if(strpos($option, '$') !== false) {
                	return '$ ' . $price;
                } else {
                	return $price;
                }
            } else {
            	if(strpos($option, '$') !== false) {
            		return '$ ' . $number;
            	} else {
            		return $number;
            	}
            }
        }
    }
    

    public function tapir_sino($valor)
    {
        if ($valor) {
            return "Sí";
        } else {
            return "No";
        }
    }
    
    
    public function tapir_numerosaletras($valor)
    {
        $Conversor = new NumerosALetras();
        return $Conversor->Convertir($valor);
    }
    

    public function tapir_abreviar($texto, $largo = 20)
    {
        if(strlen($texto) > $largo + 3) {
            return substr($texto, 0, $largo) . '...';
        } else {
            return $texto;
        }
    }
    

    public function tapir_decodehtml($valor)
    {
        return htmlspecialchars_decode($valor, ENT_QUOTES);
    }
    

    public function tapir_mejorartexto($valor)
    {
        return Tapir\BaseBundle\Helper\StringHelper::Desoraclizar($valor);
    }
    

    public function tapir_fecha($date, $dateFormat = 'full', $timeFormat = 'medium', $emptyMessage = '')
    {
        if ($date == null) {
            return $emptyMessage;
        } elseif (! ($date instanceof \DateTime)) {
            $date = str_replace(
                [ 'ene', 'abr', 'ago', 'dic' ],
                [ 'jan', 'apr', 'aug', 'dec' ],
                strtolower($date)
            );
            
            if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])/", $date)) {
                $transformer = new DateTimeToStringTransformer(null, null, 'Y-m-d H:i:s');
                $date = $transformer->reverseTransform($date);
            } elseif (preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1])-(jan|feb|mar|apr|may|jun|jul|aug|sep|oct|nov|dec)-[0-9]{2}$/", $date)) {
                $transformer = new DateTimeToStringTransformer(null, null, 'd-M-y');
                $date = $transformer->reverseTransform($date);
            } elseif (preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1])-[0-9]{4}$/", $date)) {
                $transformer = new DateTimeToStringTransformer(null, null, 'm-Y');
                $date = $transformer->reverseTransform($date);
            }
        }

        $formatValues = array(
            'none' => \IntlDateFormatter::NONE,
            'short' => \IntlDateFormatter::SHORT,
            'medium' => \IntlDateFormatter::MEDIUM,
            'long' => \IntlDateFormatter::LONG,
            'full' => \IntlDateFormatter::FULL
        );

        $patrn = null;
        $dateFormatValue = \IntlDateFormatter::NONE;
        switch($dateFormat) {
        	case 'none':
        		$dateFormatValue = \IntlDateFormatter::NONE;
        		break;
        	case 'month':
        	case 'shortmonth':
        		$dateFormatValue = \IntlDateFormatter::SHORT;
        		$patrn = 'MM/yyyy';
        		break;
        	case 'mediummonth':
        		$dateFormatValue = \IntlDateFormatter::SHORT;
        		$patrn = 'MMM/yyyy';
        		break;
        	case 'fullmonth':
        	    $dateFormatValue = \IntlDateFormatter::SHORT;
        	    $patrn = "MMMM 'de' yyyy";
        	    break;
       		case 'short':
       			$dateFormatValue = \IntlDateFormatter::SHORT;
       			$patrn = 'dd/MM/yy';
       			break;
       		case 'medium':
       			$dateFormatValue = \IntlDateFormatter::MEDIUM;
       			$patrn = 'dd/MM/yyyy';
       			break;
       		case 'long':
      			$dateFormatValue = \IntlDateFormatter::LONG;
      			break;
      		case 'full':
      			$dateFormatValue = \IntlDateFormatter::FULL;
      			break;
        }

        $formatter = \IntlDateFormatter::create('es_AR', $dateFormatValue, $formatValues[$timeFormat], $date->getTimezone()->getName(), \IntlDateFormatter::GREGORIAN, $patrn );

        return ucfirst(str_replace(',', '', $formatter->format($date->getTimestamp())));
    }
    

    public function tapir_hacetiempo($value, $format = 'Y-m-d H:i:s')
    {
        if (! $value) {
            return '';
        } elseif (! ($value instanceof \DateTime)) {
            $transformer = new DateTimeToStringTransformer(null, null, $format);
            $value = $transformer->reverseTransform($value);
        }
        return $this->distanceOfTimeInWordsFilter($value);
    }

    
    public function tapir_cantidaddedias($value, $format = 'Y-m-d H:i:s')
    {
        if (! $value) {
            return '';
        } elseif (! ($value instanceof \DateTime)) {
            $transformer = new DateTimeToStringTransformer(null, null, $format);
            $value = $transformer->reverseTransform($value);
        }
        return $this->distanceOfTimeInNumber($value);
    }

    
    public function distanceOfTimeInNumber($from_time, $to_time = null, $include_seconds = false)
    {
        $datetime_transformer = new DateTimeToStringTransformer(null, null, 'Y-m-d H:i:s');
        $timestamp_transformer = new DateTimeToTimestampTransformer();

        // Transforming to DateTime
        $from_time = (! ($from_time instanceof \DateTime)) ? $datetime_transformer->reverseTransform($from_time) : $from_time;

        $to_time = empty($to_time) ? new \DateTime('now') : $to_time;
        $to_time = (! ($to_time instanceof \DateTime)) ? $datetime_transformer->reverseTransform($to_time) : $to_time;

        // Transforming to Timestamp
        $from_time = $timestamp_transformer->transform($from_time);
        $to_time = $timestamp_transformer->transform($to_time);
        $distance_in_minutes = round((abs($to_time - $from_time)) / 60);
        $distance_in_days = round($distance_in_minutes / 1440);

        return $distance_in_days;
    }

    /**
     * Reports the approximate distance in time between two times given in seconds
     * or in a valid ISO string like.
     * For example, if the distance is 47 minutes, it'll return
     * "about 1 hour". See the source for the complete wording list.
     *
     * Integers are interpreted as seconds. So, by example to check the distance of time between
     * a created user an it's last login:
     * {{ user.createdAt|distance_of_time_in_words(user.lastLoginAt) }} returns "less than a minute".
     *
     * Set include_seconds to true if you want more detailed approximations if distance < 1 minute
     *
     * @param $from_time String
     *            or DateTime
     * @param $to_time String
     *            or DateTime
     * @param bool $include_seconds
     *
     * @return mixed
     */
    public function distanceOfTimeInWordsFilter($from_time, $to_time = null, $include_seconds = false)
    {
        $datetime_transformer = new DateTimeToStringTransformer(null, null, 'Y-m-d H:i:s');
        $timestamp_transformer = new DateTimeToTimestampTransformer();

        // Transforming to DateTime
        $from_time = (! ($from_time instanceof \DateTime)) ? $datetime_transformer->reverseTransform($from_time) : $from_time;

        $to_time = empty($to_time) ? new \DateTime('now') : $to_time;
        $to_time = (! ($to_time instanceof \DateTime)) ? $datetime_transformer->reverseTransform($to_time) : $to_time;

        // Transforming to Timestamp
        $from_time = $timestamp_transformer->transform($from_time);
        $to_time = $timestamp_transformer->transform($to_time);
        $distance_in_minutes = round((abs($to_time - $from_time)) / 60);
        $distance_in_seconds = round(abs($to_time - $from_time));

        if ($distance_in_minutes <= 1) {
            if ($include_seconds) {
                if ($distance_in_seconds < 5) {
                    return vsprintf('hace menos de %d segundos', array(
                        '%d' => 5
                    ));
                } elseif ($distance_in_seconds < 10) {
                    return vsprintf('hace menos de %d segundos', array(
                        '%d' => 10
                    ));
                } elseif ($distance_in_seconds < 20) {
                    return vsprintf('hace menos de %d segundos', array(
                        '%d' => 20
                    ));
                } elseif ($distance_in_seconds < 60) {
                    return vsprintf('hace menos de un minuto');
                } else {
                    return vsprintf('hace un minuto');
                }
            }
            return ($distance_in_minutes === 0) ? 'hace menos de un minuto' : 'hace un minuto';
        } elseif ($distance_in_minutes <= 45) {
            return vsprintf('hace %d minutos', array(
                '%d' => $distance_in_minutes
            ));
        } elseif ($distance_in_minutes <= 90) {
            return 'hace una hora';
        } elseif ($distance_in_minutes <= 1440) {
            return vsprintf('hace unas %d horas', array(
                '%d' => round($distance_in_minutes / 60)
            ));
        } elseif ($distance_in_minutes <= 2880) {
            return 'ayer';
        } else {
            $distance_in_days = round($distance_in_minutes / 1440);
            if ($distance_in_days <= 60) {
                return vsprintf('hace %d días', array(
                    '%d' => $distance_in_days
                ));
            } else {
                $distance_in_month = round($distance_in_days / 30);
                if ($distance_in_month < 20) {
                    return vsprintf('hace %d meses', array(
                        '%d' => $distance_in_month
                    ));
                } else {
                    $distance_in_year = abs(round(($distance_in_month / 12), 1, PHP_ROUND_HALF_UP));

                    if (is_float($distance_in_year)) {
                        $year = (int) $distance_in_year;
                        $month = ($distance_in_year - $year) * 10;
                        if ($year == 1 and $month == 1) {
                            return vsprintf('hace %d año y %u mes', array(
                                '%d' => $year,
                                '%u' => $month
                            ));
                        } else
                            if ($year == 1 && $month > 1) {
                                return vsprintf('hace %d año y %u meses', array(
                                    '%d' => $year,
                                    '%u' => $month
                                ));
                            } else
                                if ($month == 1 && $year > 1) {
                                    return vsprintf('hace %d años y %u mes', array(
                                        '%d' => $year,
                                        '%u' => $month
                                    ));
                                } else if ($month > 0) {
                                    return vsprintf('hace %d años y %u meses', array(
                                            '%d' => $year,
                                            '%u' => $month
                                    ));
                                } else {
                                    return vsprintf('hace %d años', array(
                                        '%d' => $year,
                                        '%u' => $month
                                    ));
                                }
                    } else
                        if ($distance_in_year == 1) {
                            return vsprintf('hace %d año', array(
                                '%d' => $distance_in_year
                            ));
                        } else {
                            return vsprintf('hace %d años', array(
                                '%d' => $distance_in_year
                            ));
                        }
                }
            }
        }
    }
    

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'tapir_formatextension';
    }
}
