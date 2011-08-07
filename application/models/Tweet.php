<?php

/** @namespace */
namespace Application\Model;

class Tweet
{
    protected $_created = null;
    protected $_from = '';
    protected $_text = '';
    protected $_location = null;

    public function setCreated($created)
    {
        $this->_created = $created;
        //new Date('2006-01-01')->setTime()
    }

    public function setFrom($from)
    {
        $this->_from = $from;
    }

    public function setText($text)
    {
        $this->_text = $text;
    }

    public function setLocation(Location $location)
    {
        $this->_location = $location;
    }

    public function getCreated()
    {
        return $this->_created;
    }

    public function getFrom()
    {
        return $this->_from;
    }

    public function getText()
    {
        return $this->_text;
    }

    public function getLocation()
    {
        return $this->_location;
    }

    public function hasLocation()
    {
        return (bool)$this->_location;
    }
}

