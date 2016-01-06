<?php
namespace Tapir\OsmBundle\Maps;

/**
 * Marker.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class Marker 
{
    use WithId;
    
    protected $Position;
    protected $Description = null;
    
    function __construct() {
        $this->setId('marker' . rand(1000, 9999));
    }
    
    /**
     * Short for ->getPosition()->getCoordinate()
     */
    public function getCoordinate() {
        return $this->getPosition()->getCoordinate();
    }
    
    /**
     * Short for ->getPosition()->getX()
     */
    public function getX() {
        return $this->getPosition()->getX();
    }
    
    /**
     * Short for ->getPosition()->getY()
     */
    public function getY() {
        return $this->getPosition()->getY();
    }
    

    /**
     * @ignore
     */
    public function getPosition()
    {
        return $this->Position;
    }

    /**
     * @ignore
     */
    public function setPosition($Position)
    {
        $this->Position = $Position;
        return $this;
    }

    /**
     * @ignore
     */
    public function getDescription()
    {
        return $this->Description;
    }

    /**
     * @ignore
     */
    public function setDescription($Description)
    {
        $this->Description = $Description;
        return $this;
    }
 
}