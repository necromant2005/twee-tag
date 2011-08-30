<?php
trait Hello {
    protected $_message = '';

    public function setMessage($message)
    {
        $this->_message = $message;
    }

    public function getMessage()
    {
        return $this->_message;
    }
}

trait TestCall
{
    public function __call($method, $args)
    {
        var_dump($method);
        var_dump($args);
    }
}

trait TestConstruct
{
    public function __construct()
    {
        var_dump('suxx');
    }
}

trait Mapping
{
    public function __call($method, $args)
    {
        list($name, $options) = $this->_getPropertyNameByMethod($method);
        $command = substr($method, 0, 3);
        if ($command=='get') return $this->_getProperty($name);
        if ($command=='set') return $this->_setProperty($name, current($args), $options);
        if ($command=='has') return $this->_hasProperty($name);
        throw new Exception('Unknow method ' . $method);
    }

    private function _setProperty($name, $value, array $options=array())
    {
        foreach ($options['validators'] as $validatorName) {
            $validatorMethodName = '_is' . $validatorName . 'Validator';
            if (!$this->{$validatorMethodName}($value)) throw new Exception('Filter ' . $validatorName . ' - fail');
        }
        $this->{$name} = $value;
    }

    private function _getProperty($name)
    {
        return $this->{$name};
    }

    private function _hasProperty($name)
    {
        return !empty($this->{$name});
    }

    private function _getPropertyNameByMethod($method)
    {
        $reflection = new ReflectionObject($this);
        foreach ($reflection->getProperties() as $property) {
            $name = '' . $property->getName();
            $transformedPropertyName = str_replace('_', '', $name);
            $cleanMethodName = lcfirst(substr($method, 3));
            if ($transformedPropertyName!=$cleanMethodName) continue;
            $comment = $property->getDocComment();
            $options = array(
                'validators' => $this->_parseValidators($comment),
            );
            return array($name, $options);
        }
        throw new Exception('Unknow method ' . $method);
    }

    private function _parseValidators($comment)
    {
        $validators = array();
        foreach(explode("\n", $comment) as $line) {
            if (!preg_match('~@validator\s+(\w+)~', $line, $match)) continue;
            $validators[] = $match[1];
        }
        return $validators;
    }
}

trait Validators
{
    private function _isStringValidator($value)
    {
        return is_string($value);
    }

    private function _isLowerCaseValidator($value)
    {
        return strtolower($value)==$value;
    }

}

class A
{
    use Hello, Mapping, Validators;

    /**
     * @var string
     * @validator String
     * @validator LowerCase
     */
    protected $_name = '';
}

$a = new A();
$a->setMessage('test');
var_dump($a->getMessage());
$a->setName('bill');
var_dump($a->getName());
$a->setName(123);

