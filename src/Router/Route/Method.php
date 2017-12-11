<?php

namespace Sid\Framework\Router\Route;

use InvalidArgumentException;

/**
 * @Annotation
 */
class Method
{
    /**
     * @var string
     */
    protected $method;



    public function __construct(array $values)
    {
        if (!isset($values["value"])) {
            throw new InvalidArgumentException(
                "Method is required."
            );
        }

        $this->method = (string) $values["value"];
    }



    public function getMethod() : string
    {
        return $this->method;
    }
}
