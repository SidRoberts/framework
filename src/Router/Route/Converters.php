<?php

namespace Sid\Framework\Router\Route;

use ArrayAccess;
use InvalidArgumentException;
use LogicException;
use Sid\Framework\ConverterInterface;

/**
 * @Annotation
 */
class Converters implements ArrayAccess
{
    /**
     * @var array
     */
    protected $converters = [];



    public function __construct(array $converters)
    {
        foreach ($converters as $key => $converter) {
            if (!is_subclass_of($converter, ConverterInterface::class)) {
                throw new InvalidArgumentException(
                    sprintf(
                        "Converter must implement %s",
                        ConverterInterface::class
                    )
                );
            }

            $this->converters[$key] = $converter;
        }
    }



    public function offsetExists($offset) : bool
    {
        return array_key_exists($offset, $this->converters);
    }

    public function offsetGet($offset)
    {
        return $this->converters[$offset];
    }

    public function offsetSet($offset, $value)
    {
        throw new LogicException(
            "Attempting to write to an immutable array"
        );
    }

    public function offsetUnset($offset)
    {
        throw new LogicException(
            "Attempting to write to an immutable array"
        );
    }
}
