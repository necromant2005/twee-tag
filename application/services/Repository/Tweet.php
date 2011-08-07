<?php

/** @namespace */
namespace Application\Service\Repository;
use Application\Service\Factory as Factory;
use Application\Service\Collection as Collection;
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
        $collection = new Collection\Collection();
        foreach ($response->results as $tweetData) {
            $collection->append($factory->create($tweetData));
        }
        return $collection;
    }
}

