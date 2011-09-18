<?php
namespace Application\Model\Tweet\Specification;

use Platform\Specification\Specification;
use Platform\Collection\Collection;
use Application\Model\Tweet;

class NoAdv implements Specification
{
    protected $_collection = array();

    public function __construct(Collection $collection)
    {
        $this->_collection = $collection;
    }

    public function isSatisfiedBy(Tweet $tweet)
    {
        return !$this->_collection->has($tweet->getFrom());
    }
}

