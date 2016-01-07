<?php
namespace Tapir\OsmBundle\GeoCoding;

use Tapir\OsmBundle\Maps\Point;

/**
 * Nominatim service.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class Nominatim implements IGeoCoder
{
    protected $container;
    
    function __construct($container) {
        $this->container = $container;
    }

    public function GetCoordinateFromAddress($address) {
        $QueryVars = array(
            'limit' => 10,
            'email' => $this->container->getParameter('nominatim_geolocation_email')
        );
        
        if(is_a($address, 'Tapir\OsmBundle\GeoCoding\Address')) {
            $QueryVars['street'] = $address->getHouse() . ' ' . $address->getStreet();
            $QueryVars['city'] = $address->getCity();
            $QueryVars['state'] = $address->getState();
            $QueryVars['country'] = $address->getCountry();
        } else {
            $QueryVars['q'] = (string)$address;
            if($address->getCountry()) {
                $QueryVars['countrycodes'] = $address->getCountry();
            }
        }
        
        //echo $this->GetQueryUrl($QueryVars) . ' <br />';
        $Resultados = $this->NominatimQuery($QueryVars);
        
        if($Resultados && is_array($Resultados) && count($Resultados) > 0) {
            foreach($Resultados as $res) {
                if($res->osm_type == 'node' || $res->category == 'amenity') {
                    return new Point($res->lat, $res->lon);
                }
            }
            return null;
        } else {
            return null;
        }
    }
    
    protected function NominatimQuery($queryVars) {
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
        curl_setopt($Curl,CURLOPT_CONNECTTIMEOUT, 8);
        
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
        return 'http://nominatim.openstreetmap.org/search?format=jsonv2&' . $QueryString;
    }
}