<?php

/** @namespace */
namespace Application\Service\Repository;
use Application\Service\Factory as Factory;
use Zend\Service\Twitter\Search;

class Tweet
{
    private $_twitter = null;

    public function __construct()
    {
        $this->_twitter = new Search;
    }

    public function search($text)
    {
        $response = $this->_twitter->search($text);
        $factory = new Factory\Tweet;
        $collection = new \ArrayObject();
        foreach ($response as $property) {
            if (!is_array($property)) continue;
            foreach ($property as $tweetData) {
                $collection->append($factory->create($tweetData));
            }
        }
        return $collection;
    }
}

