<?php

namespace Sid\Framework;

use Sid\Framework\Router\Match;
use Sid\Framework\Router\RouteCollection;

interface RouterInterface
{
    public function getRouteCollection() : RouteCollection;

    public function handle(string $uri, string $method) : Match;
}
