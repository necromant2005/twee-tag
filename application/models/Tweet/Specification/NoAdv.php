<?php
namespace Application\Model\Tweet\Specification;

use Application\Service\Specification\Specification;
use Application\Service\Collection\Collection;
use Application\Model\Tweet;

class NoAdv implements Specification
{
    protected $_collection = array();

    public function __construct()
    {
        $this->_collection = new Collection;
    }

    public function addFrom($username)
    {
        $this->_collection->append($username);
    }

    public function isSatisfiedBy(Tweet $tweet)
    {
        return !$this->_collection->has($tweet->getFrom());
    }
}

