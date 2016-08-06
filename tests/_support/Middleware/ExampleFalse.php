<?php

namespace Middleware;

use Sid\Framework\Router\Route;
use Sid\Framework\MiddlewareInterface;

class ExampleFalse implements MiddlewareInterface
{
    public function middleware(string $uri, Route $route) : bool
    {
        return false;
    }
}
