<?php

/** @namespace */
namespace Application\Model;

class Location
{
    /**
     * @var float
     */
    protected $_latitude = null;
    protected $_longitude = null;

    public function __construct($latitude, $longitude)
    {
        $this->_latitude = $latitude;
        $this->_longitude = $longitude;
    }

    public function getLatitude()
    {
        return $this->_latitude;
    }

    public function getLongitude()
    {
        return $this->_longitude;
    }

    public function __toString()
    {
        return $this->getLatitude() . 'x' . $this->getLongitude();
    }
}

