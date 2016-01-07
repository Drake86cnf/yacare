<?php
namespace Tapir\OsmBundle\GeoCoding;

use Tapir\OsmBundle\Maps\Point;
/**
 * Geocoder service.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class Address
{
    public $House, $Street, $City, $PostalCode, $State, $Country;
    
    function __construct($house = null, $street = null, $city = null, $postalCode = null, $state = null, $country = null) {
        $this->House = $house;
        $this->Street = $street;
        $this->City = $city;
        $this->PostalCode = $postalCode;
        $this->State = $state;
        $this->Country = $country;
    }
    
    public function __toString() {
        $res = '';
        if($this->House) {
            $res .= $this->House . ' ';
        }
        if($this->Street) {
            $res .= $this->Street;
        }
        if($this->City) {
            $res .= ',' . $this->City;
        }
        if($this->PostalCode) {
            $res .= ',' . $this->PostalCode;
        }
        if($this->State) {
            $res .= ',' . $this->State;
        }
        if($this->Country) {
            $res .= ',' . $this->Country;
        }
        
        return $res;
    }

    /**
     * @ignore
     */
    public function getHouse()
    {
        return $this->House;
    }

    /**
     * @ignore
     */
    public function setHouse($House)
    {
        $this->House = $House;
        return $this;
    }

    /**
     * @ignore
     */
    public function getStreet()
    {
        return $this->Street;
    }

    /**
     * @ignore
     */
    public function setStreet($Street)
    {
        $this->Street = $Street;
        return $this;
    }

    /**
     * @ignore
     */
    public function getCity()
    {
        return $this->City;
    }

    /**
     * @ignore
     */
    public function setCity($City)
    {
        $this->City = $City;
        return $this;
    }

    /**
     * @ignore
     */
    public function getState()
    {
        return $this->State;
    }

    /**
     * @ignore
     */
    public function setState($State)
    {
        $this->State = $State;
        return $this;
    }

    /**
     * @ignore
     */
    public function getCountry()
    {
        return $this->Country;
    }

    /**
     * @ignore
     */
    public function setCountry($Country)
    {
        $this->Country = $Country;
        return $this;
    }

    /**
     * @ignore
     */
    public function getPostalCode()
    {
        return $this->PostalCode;
    }

    /**
     * @ignore
     */
    public function setPostalCode($PostalCode)
    {
        $this->PostalCode = $PostalCode;
        return $this;
    }
 
}