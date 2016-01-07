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
    
    public function RenderJs($map) {
        $res = "var " . $map->getId() . " = L.map('" . $this->getDivId() . "', { 
    scrollWheelZoom: false,
    attributionControl:  false
});\n";
        if($map->getCenter()) {
            $res .= $map->getId() . ".setView([" . $map->getCenter()->getCoordinate() . "], " . $map->getZoom() . ");\n";
        } else {
            $res .= $map->getId() . ".setView([-53.7833333, -67.7], " . $map->getZoom() . ");\n";
        }
        
        $res .= "L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: 'Mapa &copy; voluntarios <a href=\"http://openstreetmap.org\">OpenStreetMap</a>, <a href=\"http://creativecommons.org/licenses/by-sa/2.0/\">CC-BY-SA</a>, Imágenes © <a href=\"http://mapbox.com\">Mapbox</a>',
    maxZoom: 18
}).addTo(" . $map->getId() . ");\n\n";
        
        $res .= $this->RenderMarkers($map);
        $res .= $this->RenderPolylines($map);

        return $res;
    }
    
    
    public function RenderMarkers($map) {
        $res = "// Markers\n";
        foreach($map->getMarkers() as $Marker) {
            $res .= "var " . $Marker->getId() . " = L.marker([" . $Marker->getCoordinate() . "]).addTo(" . $map->getId() . ");\n";
            if($Marker->getDescription()) {
                $res .= $Marker->getId() . ".bindPopup('" . $Marker->getDescription() . "').openPopup();\n";
            }
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
}