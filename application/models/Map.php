<?php

/** @namespace */
namespace Application\Model;

use Application\Service\Collection as Collection;

class Map
{
    private $_zoom = array(
        19=>0.01,
        18=>0.02,
        17=>0.05,
        16=>0.1,
        15=>0.2,
        14=>0.5,
        13=>1,
        12=>2,
        11=>5,
        10=>10,
        9=>20,
        8=>20,
        7=>50,
        6=>100,
        5=>200,
        4=>500,
        3=>1000,
        2=>2000,
        1=>5000,
    );

    public function findCenter(Collection\Collection $tweets)
    {
        $latitude = 0;
        $longitude = 0;
        $count = 0;
        foreach ($tweets as $tweet) {
            if (!$tweet->hasLocation()) continue;
            $latitude+=$tweet->getLocation()->getLatitude();
            $longitude+=$tweet->getLocation()->getLongitude();
            $count++;
        }
        return new Location($latitude/$count, $longitude/$count);
    }

    public function findZoom(Collection\Collection $tweets)
    {
        $center = $this->findCenter($tweets);
        $maxDistance = 0;
        foreach ($tweets as $tweet) {
            if (!$tweet->hasLocation()) continue;
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

