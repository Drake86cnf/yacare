<?php
namespace Tapir\OsmBundle\GeoCoding;

use Tapir\OsmBundle\Maps\Point;

/**
 * Google Maps service.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class GoogleMaps implements IGeoCoder
{
    protected $container;
    
    function __construct($container) {
        $this->container = $container;
    }
    
    public function GetCoordinateFromAddress($address) {
        $QueryVars = array(
            'key' => $this->container->getParameter('google_geolocation_apikey')
        );
        if(is_a($address, 'Tapir\OsmBundle\GeoCoding\Address')) {
            $QueryVars['address'] = $address->getHouse() . ' ' . $address->getStreet();
            
            $Components = array();
            if($address->getCity()) {
                $Components[] = "locality:" . $address->getCity();
            }
            if($address->getPostalCode()) {
                $Components[] = "postal_code:" . $address->getPostalCode();
            }
            if($address->getState()) {
                $Components[] = "administrative_area:" . $address->getState();
            }
            if($address->getCountry()) {
                $Components[] = "country:" . $address->getCountry();
            }
            if($Components && count($Components) > 0) {
                $QueryVars['components'] = implode('|', $Components);
            }
        } else {
            $QueryVars['address'] = (string)$address; 
        }

        $res = $this->GoogleMapsQuery($QueryVars);
        if($res && $res->status == 'OK' && $res->results) {
            $res = $res->results[0];
            if($res->geometry->location_type == 'ROOFTOP' || $res->geometry->location_type == 'RANGE_INTERPOLATED') {
                return new Point($res->geometry->location->lat, $res->geometry->location->lng);
            } else {
                return null;
            }
        } else {
            return null;
        }
    }
    
    protected function GoogleMapsQuery($queryVars) {
        $Url = $this->GetQueryUrl($queryVars);
        
        $Headers = array();
        $Headers[] = 'Accept: application/json,*/*';
        $Headers[] = 'Accept-Encoding: identity';
        $Headers[] = 'Accept-Language: es,en;q=0.5';
        $Headers[] = 'User-Agent: Tapir OsmBundle';
        $Headers[] = 'X-MicrosoftAjax: Delta=true';
        
        $Curl = curl_init();
        curl_setopt($Curl, CURLOPT_URL, $Url);
        curl_setopt($Curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($Curl, CURLOPT_HTTPHEADER, $Headers);
        curl_setopt($Curl, CURLOPT_CONNECTTIMEOUT, 8);
        curl_setopt($Curl, CURLOPT_SSL_VERIFYPEER, false);
        
        $Contents = curl_exec($Curl);
        if(!curl_errno($Curl)){
            $res = json_decode($Contents);
        } else {
            return null;
        }
        curl_close($Curl);
        
        return $res;
    }
    
    public function GetQueryUrl($queryVars) {
        $QueryString = http_build_query($queryVars);
        return 'https://maps.googleapis.com/maps/api/geocode/json?' . $QueryString;
    }
}