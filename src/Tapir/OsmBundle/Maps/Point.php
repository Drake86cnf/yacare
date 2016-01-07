<?php
namespace Tapir\OsmBundle\Maps;

/**
 * Point.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class Point 
{
    protected $x, $y;
    
    function __construct($x, $y) {
        $this->x = $x;
        $this->y = $y;
    }
    
    /**
     * Returns a coordinate (X, Y).
     */
    public function getCoordinate() {
        return $this->getX() . ',' . $this->getY();
    }

    /**
     * @ignore
     */
    public function getX()
    {
        return $this->x;
    }

    /**
     * @ignore
     */
    public function setX($x)
    {
        $this->x = $x;
        return $this;
    }

    /**
     * @ignore
     */
    public function getY()
    {
        return $this->y;
    }

    /**
     * @ignore
     */
    public function setY($y)
    {
        $this->y = $y;
        return $this;
    }
}