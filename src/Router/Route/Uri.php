<?php

namespace Sid\Framework\Router\Route;

use InvalidArgumentException;

/**
 * @Annotation
 */
class Uri
{
    /**
     * @var string
     */
    protected $uri = "";



    public function __construct(array $values)
    {
        if (!isset($values["value"])) {
            throw new InvalidArgumentException(
                "URI is required."
            );
        }

        $this->uri = (string) $values["value"];
    }



    public function getUri() : string
    {
        return $this->uri;
    }
}
