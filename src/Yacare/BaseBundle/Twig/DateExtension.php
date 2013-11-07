<?php

namespace Yacare\BaseBundle\Twig;

use Twig_Extension;
use Twig_Filter_Method;
use Twig_Function_Method;
use Symfony\Component\Form\Extension\Core\DataTransformer\DateTimeToStringTransformer;
use Symfony\Component\Form\Extension\Core\DataTransformer\DateTimeToTimestampTransformer;
use Symfony\Component\Validator\Constraints\DateTime;

class DateExtension extends \Twig_Extension
{
    public function getFilters() 
    {
        return array(
            'time_ago'  => new \Twig_Filter_Method($this, 'time_ago'),
            'localizeddate'  => new \Twig_Filter_Method($this, 'localizeddate')
        );
    }
    
    public function localizeddate($date, $dateFormat = 'full', $timeFormat = 'medium') {
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

        return ucfirst($formatter->format($date->getTimestamp()));
    }

    public function time_ago($value, $format = 'Y-m-d H:s') 
    {
        if(!($value instanceof \DateTime)) {
            $transformer = new DateTimeToStringTransformer(null, null, $format);
            $value = $transformer->reverseTransform($value);
        }
        return $this->distanceOfTimeInWordsFilter($value);
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
                    return sprintf('hace menos de %seconds segundos', array('%seconds' => 5));
                } elseif($distance_in_seconds < 10) {
                    return sprintf('hace menos de %seconds segundos', array('%seconds' => 10));
                } elseif($distance_in_seconds < 20){
                    return sprintf('hace menos de %seconds segundos', array('%seconds' => 20));
                } elseif($distance_in_seconds < 60){
                    return sprintf('hace menos de un minuto');
                } else {
                    return sprintf('hace un minuto');
                }
            }
            return ($distance_in_minutes===0) ? 'hace menos de un minuto' : 'hace un minuto';
        }
        elseif ($distance_in_minutes <= 45){
            return sprintf('hace %minutes minutos', array('%minutes' => $distance_in_minutes));
        }
        elseif ($distance_in_minutes <= 90){
            return 'hace una hora';
        }
        elseif ($distance_in_minutes <= 1440){
            return sprintf('hace unas %hours horas', array('%hours' => round($distance_in_minutes/60)));
        }
        elseif ($distance_in_minutes <= 2880){
            return 'ayer';
        }
        else{
            return sprintf('hace %days días', array('%days' => round($distance_in_minutes/1440)));
        }
    }
 
    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'time_ago';
    }
}
