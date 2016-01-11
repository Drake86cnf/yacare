<?php
namespace Tapir\OsmBundle\Maps;

/**
 * Map.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class Map 
{
    use WithId;
    
    /**
     * Zoom level.
     */
    protected $Zoom = 14;
    
    /**
     * The map current center.
     */
    protected $Center = null;
    
    /**
     * A collection of markers.
     */
    protected $Markers = array();
    
    /**
     * A collection of polylines.
     */
    protected $Polylines = array();

    
    function __construct() {
        $this->setId('map' . rand(1000, 9999));
    }
    
    
    /**
     * Adds a marker to the map.
     * @param Marker $marker
     */
    public function addMarker($marker) {
        $this->Markers[] = $marker;
    }
    
    /**
     * Adds a polyline to the map.
     * @param Polyline $polyline
     */
    public function addPolyline($polyline) {
        $this->Polylines[] = $polyline;
    }
    

    /**
     * @ignore
     */
    public function getZoom()
    {
        return $this->Zoom;
    }

    /**
     * @ignore
     */
    public function setZoom($Zoom)
    {
        $this->Zoom = $Zoom;
        return $this;
    }

    /**
     * @ignore
     */
    public function getMarkers()
    {
        return $this->Markers;
    }

    /**
     * @ignore
     */
    public function setMarkers($Markers)
    {
        $this->Markers = $Markers;
        return $this;
    }

    /**
     * @ignore
     */
    public function getPolylines()
    {
        return $this->Polylines;
    }

    /**
     * @ignore
     */
    public function setPolylines($Polylines)
    {
        $this->Polylines = $Polylines;
        return $this;
    }

    /**
     * @ignore
     */
    public function getCenter()
    {
        return $this->Center;
    }

    /**
     * @ignore
     */
    public function setCenter($Center)
    {
        $this->Center = $Center;
        return $this;
    }
 
 
 
}