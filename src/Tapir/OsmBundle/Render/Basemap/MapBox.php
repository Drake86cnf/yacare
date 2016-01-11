<?php
namespace Tapir\OsmBundle\Render\Basemap;

/**
 * MapBox basemap provider.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class MapBox extends Provider
{
    function __construct($container = null) {
        $this->container = $container;
    }
    
    public function getTileUrl() {
        return "https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=" . $this->getToken();
    }
    
    public function getOptions() {
        return array(
            'attribution' => 'Imágenes <a href=\"http://mapbox.com/about/maps/\">MapBox</a> &mdash; Datos &copy; <a href=\"http://www.openstreetmap.org/copyright\">OpenStreetMap</a>',
            'subdomains' => 'abcd',
            'id' => 'mapbox.streets',
            'accessToken' => $this->getToken()
        );
    }
    
    public function getToken() {
        return $this->container->getParameter('mapbox_token');
    }
}