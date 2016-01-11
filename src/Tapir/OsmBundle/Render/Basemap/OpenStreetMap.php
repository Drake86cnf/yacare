<?php
namespace Tapir\OsmBundle\Render\Basemap;

/**
 * OpenStreetMap basemap provider.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class OpenStreetMap extends Provider
{
    function __construct($container = null) {
        $this->container = $container;
    }
    
    public function getTileUrl() {
        return "http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png";
    }
    
    public function getOptions() {
        return array(
            'attribution' => 'Datos &copy; <a href=\"http://www.openstreetmap.org/copyright\">OpenStreetMap</a>'
        );
    }
}