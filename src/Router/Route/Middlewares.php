<?php

namespace Sid\Framework\Router\Route;

use InvalidArgumentException;
use Iterator;
use Sid\Framework\MiddlewareInterface;

/**
 * @Annotation
 */
class Middlewares implements Iterator
{
    /**
     * @var array
     */
    protected $middlewares = [];



    public function __construct(array $values)
    {
        if (!isset($values["value"])) {
            $values["value"] = [];
        }



        foreach ($values["value"] as $middleware) {
            if (!is_subclass_of($middleware, MiddlewareInterface::class)) {
                throw new InvalidArgumentException(
                    sprintf(
                        "Middleware must implement %s",
                        MiddlewareInterface::class
                    )
                );
            }

            $this->middlewares[] = $middleware;
        }
    }



    public function rewind()
    {
        reset($this->middlewares);
    }
  
    public function current()
    {
        return current($this->middlewares);
    }
  
    public function key()
    {
        return key($this->middlewares);
    }
  
    public function next()
    {
        return next($this->middlewares);
    }
  
    public function valid()
    {
        $key = key($this->middlewares);

        return ($key !== null && $key !== false);
    }
}
