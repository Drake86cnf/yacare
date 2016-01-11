<?php
namespace Tapir\OsmBundle\Render;

/**
 * A map renderer for Leaflet.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class Leaflet extends Renderer
{
    protected $DivId;
    protected $Map;
    public $container;
    
    function __construct($container = null) {
        $this->container = $container;
    }
    
    public function RenderJs($map = null) {
        if($map) {
            $this->setMap($map);
        }

        $res = "var " . $this->getMap()->getId() . " = L.map('" . $this->getDivId() . "', { 
    fullscreenControl: true,
    scrollWheelZoom: false,
    attributionControl: false
});\n";
        if($this->getMap()->getCenter()) {
            $res .= $this->getMap()->getId() . ".setView([" . $this->getMap()->getCenter()->getCoordinate() . "], " . $this->getMap()->getZoom() . ");\n";
        } else {
            $res .= $this->getMap()->getId() . ".setView([-53.7833333, -67.7], " . $this->getMap()->getZoom() . ");\n";
        }
        
        $TileLayer = new Basemap\MapBox($this->container);
        $res .= "L.tileLayer('" . $TileLayer->getTileUrl() . "', ";
        $res .= json_encode($TileLayer->getOptions());
        $res .= ").addTo(" . $this->getMap()->getId() . ");\n\n";
        
        $res .= $this->RenderMarkers($this->getMap());
        $res .= $this->RenderPolylines($this->getMap());

        return $res;
    }
    
    public function RenderMarkers($map) {
        $res = "// Markers\n";
        foreach($map->getMarkers() as $Marker) {
            $res .= "var " . $Marker->getId() . " = L.marker([" . $Marker->getCoordinate() . "]).addTo(" . $map->getId() . ");\n";
            //if($Marker->getDescription()) {
            //    $res .= $Marker->getId() . ".bindPopup('" . $Marker->getDescription() . "').openPopup();\n";
            //}
        }
        return $res;
    }
    
    public function RenderPolylines($map) {
        $res = "// Polylines\n";
        foreach($map->getPolylines() as $Polyline) {
            
            $respoints = ""; 
            foreach($Polyline->getPoints() as $Point) {
                if($respoints) {
                    $respoints .= ",\n";
                }
                $respoints .= "    [" . $Point->getCoordinate() . "]";
            }
            $res .= "var " . $Polyline->getId() . " = L.polygon([" . $respoints . "]).addTo(" . $map->getId() . ");\n";
        }
        return $res;
    }
    

    /**
     * @ignore
     */
    public function getDivId()
    {
        return $this->DivId;
    }

    /**
     * @ignore
     */
    public function setDivId($DivId)
    {
        $this->DivId = $DivId;
        return $this;
    }

    /**
     * @ignore
     */
    public function getMap()
    {
        return $this->Map;
    }

    /**
     * @ignore
     */
    public function setMap($Map)
    {
        $this->Map = $Map;
        return $this;
    }
 
}