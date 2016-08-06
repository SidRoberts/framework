<?php

namespace Sid\Framework;

use Sid\Framework\Router\Route;

interface MiddlewareInterface
{
    public function middleware(string $uri, Route $route) : bool;
}
