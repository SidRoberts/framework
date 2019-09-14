<?php

namespace Tests\Middleware;

use Sid\Framework\MiddlewareInterface;
use Sid\Framework\Router\Route;

class ExampleFalse implements MiddlewareInterface
{
    public function middleware(string $uri, Route $route) : bool
    {
        return false;
    }
}
