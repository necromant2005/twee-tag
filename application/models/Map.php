<?php

/** @namespace */
namespace Application\Model;

use Application\Service\Collection as Collection;

class Map
{
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
}

