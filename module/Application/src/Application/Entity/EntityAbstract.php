<?php

namespace Application\Entity;

use Zend\Stdlib\ArraySerializableInterface;
use Application\Entity\SerializableInterface;

abstract class EntityAbstract implements ArraySerializableInterface, \ArrayAccess
{

    public function offsetExists($offset)
    {
        $method = 'get' . ucfirst($offset);
        return \method_exists($this, $method);
    }

    public function offsetSet($offset, $value)
    {
        $method = 'set' . ucfirst($offset);
        if (\method_exists($this, $method)) {
            $this->$method($value);
        }
    }

    public function offsetGet($offset)
    {
        $method = 'get' . ucfirst($offset);
        if (\method_exists($this, $method)) {
            return $this->$method();
        }
    }

    public function offsetUnset($offset)
    {
        $this->offsetSet($offset, null);
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    public function exchangeArray(array $array)
    {
        return $this->setFromArray($array);
    }

    public function setFromArray($data)
    {
        if (is_object($data)) {
            if ($data instanceof \ArrayObject) {
                $data = $data->getArrayCopy();
            } elseif (method_exists($data, 'toArray')) {
                $data = $data->toArray();
            } elseif (!$data instanceof \Iterator) {
                throw new \Exception("Model should be instanciated with an array or an Iterable object");
            }
        } elseif (!is_array($data)) {
            throw new \Exception("Model should be instanciated with an array or an Iterable object");
        }

        foreach ($data as $key => $value) {
            $this->offsetSet($key, $value);
        }

        return $this;
    }

}
