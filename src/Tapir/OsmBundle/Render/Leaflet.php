<?php
namespace Tapir\OsmBundle\Render;

/**
 * A map renderer for Leaflet.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class Leaflet extends Renderer
{
    protected $DivId, $DivClass = "osmbundle_map", $DivStyle = null;
    protected $Map;
    public $container;
    
    function __construct($container = null) {
        $this->container = $container;
    }
    
    public function Render($map = null) {
        if($map) {
            $this->setMap($map);
        }
        
        $res = $this->RenderDiv();
        $res .= "<script type=\"text/javascript\">\n" . $this->RenderJs() . "\n</script>\n";
        
        return $res;
    }
    
    public function RenderDiv() {
        $res = '';
        
        $res .= "document.getElementById('" . $this->getMap()->getId() . "').innerHTML = '<div";
        if($this->DivClass) {
            $res .= " style=\"" . $this->getMap()->getId() . "\"";
        }
        if($this->DivStyle) {
            $res .= " class=\"" . $this->getMap()->getId() . "\"";
        }
        $res .= "></div>';\n\n";
        
        return $res;
    }
    
    public function RenderJs() {
        $res = "var " . $this->getMap()->getId() . " = L.map('" . $this->getDivId() . "', { 
    //scrollWheelZoom: false,
    attributionControl: false,
            
    fullscreenControl: true, // Control.FullScreen plugin
    fullscreenControlOptions: {
        position: 'topleft',
        title: 'Mostrar en pantalla completa',
        titleCancel: 'Salir del modo pantalla completa'
    },

    sleep: true,       // Leaflet.Sleep pluing
    sleepTime: 750,    // time(ms) until map sleeps on mouseout
    wakeTime: 750,     // time(ms) until map wakes on mouseover
    sleepNote: false,   // defines whether the user is prompted on how to wake map
    //hoverToWake: true, // should hovering wake the map?
    //wakeMessage: ((true?'Deslice el ratón ' : 'Haga clic ') + ' para usar el mapa'),
    sleepOpacity: .75   // opacity (between 0 and 1) of inactive map
});\n";
        if($this->getMap()->getCenter()) {
            // Explicit center view
            $res .= $this->getMap()->getId() . ".setView([" . $this->getMap()->getCenter()->getCoordinate() . "], " . $this->getMap()->getZoom() . ");\n";
        } elseif(count($this->getMap()->getMarkers()) > 0) {
            // Center view on the first marker
            $res .= $this->getMap()->getId() . ".setView([" . $this->getMap()->getMarkers()[0]->getCoordinate() . "], " . $this->getMap()->getZoom() . ");\n";
        } else {
            // Center view in the best city in the world (after Buenos Aires and maybe Rome (and maybe Madrid))
            $res .= $this->getMap()->getId() . ".setView([-53.7833333, -67.7], " . $this->getMap()->getZoom() . ");\n";
        }
        
        $TileLayer = new Basemap\MapBox($this->container);
        $res .= "L.tileLayer('" . $TileLayer->getTileUrl() . "', ";
        $TileOptions = $TileLayer->getOptions();
        $TileOptions['maxZoom'] = 18;
        $res .= json_encode($TileOptions);
        $res .= ").addTo(" . $this->getMap()->getId() . ");\n\n";
        
        $res .= $this->RenderMarkers($this->getMap());
        $res .= $this->RenderPolylines($this->getMap());

        return $res;
    }
    
    public function RenderMarkers($map) {
        $res = "// Markers\n";
        foreach($map->getMarkers() as $Marker) {
            $res .= "var " . $Marker->getId() . " = L.marker([" . $Marker->getCoordinate() . "]).addTo(" . $map->getId() . ");\n";
            if($Marker->getDescription()) {
                $res .= $Marker->getId() . ".bindPopup('" . $Marker->getDescription() . "');\n";
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