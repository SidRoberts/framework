<?php

namespace Sid\Framework\Middleware;

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



    public function run(array $parameters = []) : bool
    {
        foreach ($this->middlewares as $middleware) {
            $success = call_user_func_array(
                [
                    $middleware,
                    "middleware",
                ],
                $parameters
            );

            if (!$success) {
                return false;
            }
        }

        return true;
    }
}
