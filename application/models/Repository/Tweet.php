<?php

/** @namespace */
namespace Application\Model\Repository;
use Application\Model\Factory as Factory;
use Platform\Collection as Collection;
use Zend\Service\Twitter\Search;
use Zend\Http;
use Zend\Rest;
use Zend\Feed;
use Zend\Json;
use Application\Model\Location;
use Application\Model\DbTable;

class Tweet
{
    private $_twitter = null;
    private $_dbTable = null;

    public function __construct()
    {
        $this->_twitter = new Search;
        $this->_dbTable = new DbTable\UsernameLocation;
    }

    public function search($text)
    {
        $response = $this->_twitter->search($text);
        $factory = new Factory\Tweet;
        $collection = new Collection\Collection();
        foreach ($response->results as $tweetData) {
            $tweet = $factory->create($tweetData);
            if (!$tweet->hasLocation()) {
                $tweet->setLocation($this->findLocationByUsername($tweet->getFrom()));
            }
            $collection->append($tweet);
        }
        return $collection;
    }

    public function findLocationByUsername($username)
    {
        if ($this->hasLocationByUsername($username)) {
            return $this->loadLocationByUsername($username);
        }
        $profile = $this->findProfile($username);
        if (empty($profile->location)) {
            $this->saveLocationByUsername($username, null);
            return null;
        }
        $location = $this->findLocationByLocationName($profile->location);
        $this->saveLocationByUsername($username, $location);
        return $location;
    }

    public function findProfile($username)
    {
        //http://api.twitter.com/1/users/show.json?screen_name=TwitterAPI
        $client = new Rest\Client\RestClient();
        $client->setUri("http://api.twitter.com");
        $client->setHeaders('Accept-Charset', 'ISO-8859-1,utf-8');
        $_query = array('screen_name' => $username);
        $response = $client->restGet('/1/users/show.json', $_query);
        return Json\Json::decode($response->getBody());
    }

    public function findLocationByLocationName($locationName)
    {
        //http://maps.google.com/maps/geo?q=Kiev%20/%20Kyiv,%20Ukraine&output=json&oe=utf8
        $client = new Rest\Client\RestClient();
        $client->setUri("http://maps.google.com");
        $client->setHeaders('Accept-Charset', 'ISO-8859-1,utf-8');
        $_query = array('q' => $locationName, 'output'=>'json', 'oe'=>'utf8');
        $response = $client->restGet('/maps/geo', $_query);
        $location = Json\Json::decode($response->getBody());
        if (empty($location->Placemark)) return null;
        $placemark = $location->Placemark;
        if (!count($placemark)) return null;
        $place = current($placemark);
        list($long, $lat) = $place->Point->coordinates;
        return new Location($lat, $long);
    }

    public function saveLocationByUsername($username, Location $location=null)
    {
        try {
            if ($location) {
                $this->_dbTable->insert(array(
                    'username'=>$username,
                    'latitude'=>$location->getLatitude(),
                    'longitude'=>$location->getLongitude()));
            } else {
                $this->_dbTable->insert(array('username'=>$username));
            }
         } catch (\Zend\Db\Statement\Exception $e) { }
         return $location;
    }

    public function loadLocationByUsername($username)
    {
        $record = $this->_dbTable->find($username)->current();
        if (!$record->latitude || !$record->longitude) return null;
        return new Location($record->latitude, $record->longitude);
    }

    public function hasLocationByUsername($username)
    {
        return (bool)$this->_dbTable->find($username)->count();
    }
}

