<?php

/** @namespace */
namespace Application\Model;

use Platform\Collection as Collection;

class Map
{
    private $_tweets = null;

    private $_zoom = array(
        19=>0.01, 18=>0.02, 17=>0.05, 16=>0.1, 15=>0.2,
        14=>0.5, 13=>1, 12=>2, 11=>5,
        10=>10, 9=>15, 8=>25, 7=>50, 6=>100,
        5=>200, 4=>500, 3=>1000, 2=>2000, 1=>5000,
    );

    public function __construct(Collection\Collection $tweets)
    {
        $this->_tweets = $tweets->filter(new Tweet\Specification\HasLocation);
    }

    public function getCenter()
    {
        $latitude = 0;
        $longitude = 0;
        $count = 0;
        foreach ($this->_tweets as $tweet) {
            $latitude+=$tweet->getLocation()->getLatitude();
            $longitude+=$tweet->getLocation()->getLongitude();
            $count++;
        }
        if ($count) {
            return new Location($latitude/$count, $longitude/$count);
        }
        return new Location($latitude, $longitude);
    }

    public function getZoom()
    {
        $center = $this->getCenter();
        if (!$center->getLatitude() && !$center->getLongitude()) return 2;
        $maxDistance = 0;
        foreach ($this->_tweets as $tweet) {
            $distance = $this->distance($center, $tweet->getLocation());
            if ($distance>$maxDistance) $maxDistance = $distance;
        }
        foreach ($this->_zoom as $zoom=>$size) {
            $plot = $size*10;
            if ($plot>$maxDistance) break;
        }
        return $zoom;
    }

    public function distance(Location $p1, Location $p2)
    {
        $R = 6371;
        $d = acos( sin($this->toRad($p1->getLatitude()))*sin($this->toRad($p2->getLatitude())) +
        cos($this->toRad($p1->getLatitude()))*cos($this->toRad($p2->getLatitude())) *
        cos($this->toRad($p2->getLongitude())-$this->toRad($p1->getLongitude()))) * $R;
        return $d;
    }


    public function toRad($number)
    {
        return $number * M_PI / 180;
    }
}

