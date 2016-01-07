<?php
namespace Tapir\OsmBundle\Maps;

/**
 * Polyline.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class Polyline 
{
    use WithId;
    
    protected $Points = array();
    
    function __construct() {
        $this->setId('polyline' . rand(1000, 9999));
    }
    
    public function addPoint($point) {
        $this->Points[] = $point;
    }

    /**
     * @ignore
     */
    public function getPoints()
    {
        return $this->Points;
    }

    /**
     * @ignore
     */
    public function setPoints($Points)
    {
        $this->Points = $Points;
        return $this;
    }
}