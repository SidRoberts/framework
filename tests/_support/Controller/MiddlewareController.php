<?php

namespace Controller;

use Sid\Framework\Controller;

use Sid\Framework\Router\Route\Uri;
use Sid\Framework\Router\Route\Middlewares;

class MiddlewareController extends Controller
{
    /**
     * @Uri("/middleware/true")
     *
     * @Middlewares({
     *     "Middleware\ExampleTrue"
     * })
     */
    public function true()
    {
    }

    /**
     * @Uri("/middleware/false")
     *
     * @Middlewares({
     *     "Middleware\ExampleFalse"
     * })
     */
    public function false()
    {
    }

    /**
     * @Uri("/middleware/true-false")
     *
     * @Middlewares({
     *     "Middleware\ExampleTrue",
     *     "Middleware\ExampleFalse"
     * })
     */
    public function multiple1()
    {
    }

    /**
     * @Uri("/middleware/false-true")
     *
     * @Middlewares({
     *     "Middleware\ExampleFalse",
     *     "Middleware\ExampleTrue"
     * })
     */
    public function multiple2()
    {
    }
}
