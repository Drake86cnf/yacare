<?php
namespace Tapir\OsmBundle\Maps;

/**
 * Adds an Id field to an object.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
trait WithId
{
    /**
     * Unique Id for this object.
     */
    protected $Id;
    
    /**
     * @ignore
     */
    public function getId()
    {
        return $this->Id;
    }
    
    /**
     * @ignore
     */
    public function setId($Id)
    {
        $this->Id = $Id;
        return $this;
    }
}