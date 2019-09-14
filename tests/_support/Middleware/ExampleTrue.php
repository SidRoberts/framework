<?php

namespace Tests\Middleware;

use Sid\Framework\MiddlewareInterface;
use Sid\Framework\Router\Route;

class ExampleTrue implements MiddlewareInterface
{
    public function middleware(string $uri, Route $route) : bool
    {
        return true;
    }
}
