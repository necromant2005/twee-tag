<?php
namespace Platform\Collection;
use Platform\Specification\Specification;

class Collection extends \ArrayObject
{
    public function has($pattern)
    {
        foreach ($this as $value) {
            if ($value==$pattern) return true;
        }
        return false;
    }

    public function filter(Specification $specification)
    {
        $collection = new Collection();
        foreach ($this as $value) {
            if (!$specification->isSatisfiedBy($value)) continue;
            $collection->append($value);
        }
        return $collection;
    }
}

