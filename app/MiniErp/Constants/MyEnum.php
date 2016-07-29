<?php
namespace MiniErp\Constants;

/**
 * I got this code from http://www.whitewashing.de/2009/08/31/enums-in-php.html
 * 
 */
abstract class MyEnum
{
    final public function __construct($value)
    {
        $c = new ReflectionClass($this);
        if(!in_array($value, $c->getConstants())) {
            throw IllegalArgumentException();
        }
        $this->value = $value;
    }

    final public function __toString()
    {
        return $this->value;
    }
}