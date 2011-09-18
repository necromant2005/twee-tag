<?php
namespace Application\Model\Tweet\Specification;

use Platform\Specification\Specification;
use Application\Model\Tweet;

class HasLocation implements Specification
{
    public function isSatisfiedBy(Tweet $tweet)
    {
        return $tweet->hasLocation();
    }
}

