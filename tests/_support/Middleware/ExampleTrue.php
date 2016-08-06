<?php

namespace Middleware;

use Sid\Framework\Router\Route;
use Sid\Framework\MiddlewareInterface;

class ExampleTrue implements MiddlewareInterface
{
    public function middleware(string $uri, Route $route) : bool
    {
        return true;
    }
}
