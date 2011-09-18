<?php
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
        foreach ($options['validators'] as $validator) {
            list($validatorName) = $validator;
            $validatorMethodName = '_is' . ucfirst($validatorName) . 'Validator';
            if (!method_exists($this, $validatorMethodName)) continue;
            if ($this->{$validatorMethodName}($value)) continue;
            throw new Exception('Filter ' . $validatorName . ' - fail given "' . var_export($value, true) . '"');
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
        $validators = $this->_parseDeaultTypeValidators($comment);
        foreach(explode("\n", $comment) as $line) {
            if (!preg_match('~@validator\s+(\w+)~', $line, $match)) continue;
            $validators[] = array($match[1]);
        }
        return $validators;
    }

    private function _parseDeaultTypeValidators($comment)
    {
        $validators = array();
        foreach(explode("\n", $comment) as $line) {
            if (!preg_match('~@var\s+(\w+)~', $line, $match)) continue;
            $validators[] = array($match[1]);
        }
        return $validators;
    }
}

