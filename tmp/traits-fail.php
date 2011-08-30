<?php
trait Hello
{
    protected $_some = '';
    public function set($name)
    {
        $this->_some = $name;
    }

    public function get()
    {
       return  $this->_some;
    }
}

trait Call
{
    public function __call($method, $args)
    {
        $reflection = new ReflectionObject($this);
        foreach ($reflection->getProperties() as $property) {
            $transformedPropertyName = str_replace('_', '', $property->getName());
            $property->getName();
            current($args);
        }
    }
}

class A {
    use Hello, Call;

    protected $_name = '';
}

$a = new A();
$a->set('cal');
$a->get();
$a->setName('Jo');

