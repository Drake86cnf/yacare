<?php

namespace Tapir\BaseBundle\Twig;

use Twig_Extension;
use Twig_Filter_Method;
use Twig_Function_Method;
use Symfony\Component\Form\Extension\Core\DataTransformer\DateTimeToStringTransformer;
use Symfony\Component\Form\Extension\Core\DataTransformer\DateTimeToTimestampTransformer;

class FormatExtension extends \Twig_Extension
{
    public function getFilters() 
    {
        return array(
            new \Twig_SimpleFilter('tapir_hacetiempo', array($this, 'tapir_hacetiempo')),
            new \Twig_SimpleFilter('tapir_cantidaddedias', array($this, 'tapir_cantidaddedias')),
            new \Twig_SimpleFilter('tapir_sino', array($this, 'tapir_sino')),
            new \Twig_SimpleFilter('tapir_fecha', array($this, 'tapir_fecha')),
            new \Twig_SimpleFilter('tapir_importe', array($this, 'tapir_importe'))
        );
    }
    
    public function tapir_importe($number, $decimals = 2, $decPoint = '.', $thousandsSep = ',')
    {
        $price = number_format($number, $decimals, $decPoint, $thousandsSep);
        $price = $price;

        return $price;
    }
    

    public function tapir_sino($valor)
    {
        if ($valor) {            
            return "Sí";
        } else {
             return "No";             
        }
        
    }
        
    
    public function tapir_fecha($date, $dateFormat = 'full', $timeFormat = 'medium') {
        if ($date == null) {
            return '';
        }

        $formatValues = array(
            'none' => \IntlDateFormatter::NONE,
            'short' => \IntlDateFormatter::SHORT,
            'medium' => \IntlDateFormatter::MEDIUM,
            'long' => \IntlDateFormatter::LONG,
            'full' => \IntlDateFormatter::FULL,
        );

        $formatter = \IntlDateFormatter::create(
            'es_AR',
            $formatValues[$dateFormat],
            $formatValues[$timeFormat],
            $date->getTimezone()->getName(),
            \IntlDateFormatter::GREGORIAN,
            null
        );

        return ucfirst(str_replace(',', '', $formatter->format($date->getTimestamp())));
    }

    public function tapir_hacetiempo($value, $format = 'Y-m-d H:s') 
    {
        if (!$value) {
            return '';
        }
        if (!($value instanceof \DateTime)) {
            $transformer = new DateTimeToStringTransformer(null, null, $format);
            $value = $transformer->reverseTransform($value);
        }
        return $this->distanceOfTimeInWordsFilter($value);
    }
    
        
    public function tapir_cantidaddedias($value, $format = 'Y-m-d H:s') 
    {
        if (!$value) {
            return '';
        }
        if (!($value instanceof \DateTime)) {
            $transformer = new DateTimeToStringTransformer(null, null, $format);
            $value = $transformer->reverseTransform($value);
        }
        return $this->distanceOfTimeInNumber($value);
    }
    
    public function distanceOfTimeInNumber($from_time, $to_time = null, $include_seconds = false)
    {
        $datetime_transformer = new DateTimeToStringTransformer(null, null, 'Y-m-d H:i:s');
        $timestamp_transformer = new DateTimeToTimestampTransformer();

        # Transforming to DateTime
        $from_time = (!($from_time instanceof \DateTime)) ? $datetime_transformer->reverseTransform($from_time) : $from_time;

        $to_time = empty($to_time) ? new \DateTime('now') : $to_time;
        $to_time = (!($to_time instanceof \DateTime)) ? $datetime_transformer->reverseTransform($to_time) : $to_time;

        # Transforming to Timestamp
        $from_time = $timestamp_transformer->transform($from_time);
        $to_time = $timestamp_transformer->transform($to_time);
        $distance_in_minutes = round((abs($to_time - $from_time))/60);
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
    * @param $from_time String or DateTime
    * @param $to_time String or DateTime
    * @param bool $include_seconds
    *
    * @return mixed
    */
    public function distanceOfTimeInWordsFilter($from_time, $to_time = null, $include_seconds = false)
    {
        $datetime_transformer = new DateTimeToStringTransformer(null, null, 'Y-m-d H:i:s');
        $timestamp_transformer = new DateTimeToTimestampTransformer();

        # Transforming to DateTime
        $from_time = (!($from_time instanceof \DateTime)) ? $datetime_transformer->reverseTransform($from_time) : $from_time;

        $to_time = empty($to_time) ? new \DateTime('now') : $to_time;
        $to_time = (!($to_time instanceof \DateTime)) ? $datetime_transformer->reverseTransform($to_time) : $to_time;

        # Transforming to Timestamp
        $from_time = $timestamp_transformer->transform($from_time);
        $to_time = $timestamp_transformer->transform($to_time);
        $distance_in_minutes = round((abs($to_time - $from_time))/60);
        $distance_in_seconds = round(abs($to_time - $from_time));

        if ($distance_in_minutes <= 1) {
            if ($include_seconds) {
                if ($distance_in_seconds < 5) {
                    return vsprintf('hace menos de %d segundos', array('%d' => 5));
                } elseif($distance_in_seconds < 10) {
                    return vsprintf('hace menos de %d segundos', array('%d' => 10));
                } elseif($distance_in_seconds < 20){
                    return vsprintf('hace menos de %d segundos', array('%d' => 20));
                } elseif($distance_in_seconds < 60){
                    return vsprintf('hace menos de un minuto');
                } else {
                    return vsprintf('hace un minuto');
                }
            }
            return ($distance_in_minutes===0) ? 'hace menos de un minuto' : 'hace un minuto';
        } elseif ($distance_in_minutes <= 45) {
            return vsprintf('hace %d minutos', array('%d' => $distance_in_minutes));
        } elseif ($distance_in_minutes <= 90) {
            return 'hace una hora';
        } elseif ($distance_in_minutes <= 1440) {
            return vsprintf('hace unas %d horas', array('%d' => round($distance_in_minutes/60)));
        } elseif ($distance_in_minutes <= 2880) {
            return 'ayer';
        } else {
            $distance_in_days = round($distance_in_minutes / 1440);
            if ($distance_in_days <= 60) {
                return vsprintf('hace %d días', array('%d' => $distance_in_days));
            } else{
                 $distance_in_month=round($distance_in_days / 30);
                 if ($distance_in_month < 20) {
                    return vsprintf('hace %d meses', array('%d' => $distance_in_month)); 
                 } else {
                    $distance_in_year = abs(round(($distance_in_month / 12), 1, PHP_ROUND_HALF_UP));

                    if (is_float($distance_in_year)) {
                        $year = (int)$distance_in_year;
                        $month = ($distance_in_year-$year) * 10;
                        if ($year == 1 and $month == 1) {
                            return vsprintf('hace %d año y %u mes', array('%d' =>$year, '%u' =>$month));
                        } else if ($year == 1) {
                            return vsprintf('hace %d año y %u meses', array('%d' =>$year, '%u' =>$month));
                        } else {
                            return vsprintf('hace %d años y %u mes', array('%d' =>$year, '%u' =>$month));
                        }
                    } else if ($distance_in_year == 1) {
                        return vsprintf('hace %d año', array('%d' => $distance_in_year));
                    } else {
                        return vsprintf('hace %d años', array('%d' => $distance_in_year));
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
