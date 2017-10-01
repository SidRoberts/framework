<?php

namespace Sid\Framework\Middleware;

use Sid\Framework\Router\Route;
use Sid\Framework\MiddlewareInterface;

class Runner
{
    /**
     * @var array
     */
    protected $middlewares = [];



    public function getMiddlewares() : array
    {
        return $this->middlewares;
    }

    public function addMiddleware(MiddlewareInterface $middleware)
    {
        $this->middlewares[] = $middleware;
    }



    public function run(string $uri, Route $route) : bool
    {
        foreach ($this->middlewares as $middleware) {
            $success = $middleware->middleware($uri, $route);

            if (!$success) {
                return false;
            }
        }

        return true;
    }
}
