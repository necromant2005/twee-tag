<?php
class A
{
    protected $_name = '';

    public function foo()
    {
        $reflection = new ReflectionObject($this);
        foreach ($reflection->getProperties() as $property) {
            $property->getName();
            $property->getName();
        }
    }
}

$a = new A();
$a->foo();

