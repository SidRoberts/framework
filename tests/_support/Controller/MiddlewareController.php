<?php

namespace Tests\Controller;

use Sid\Framework\Controller;

use Sid\Framework\Router\Route\Uri;
use Sid\Framework\Router\Route\Middlewares;

class MiddlewareController extends Controller
{
    /**
     * @Uri("/middleware/true")
     *
     * @Middlewares({
     *     "Tests\Middleware\ExampleTrue"
     * })
     */
    public function true()
    {
    }

    /**
     * @Uri("/middleware/false")
     *
     * @Middlewares({
     *     "Tests\Middleware\ExampleFalse"
     * })
     */
    public function false()
    {
    }

    /**
     * @Uri("/middleware/true-false")
     *
     * @Middlewares({
     *     "Tests\Middleware\ExampleTrue",
     *     "Tests\Middleware\ExampleFalse"
     * })
     */
    public function multiple1()
    {
    }

    /**
     * @Uri("/middleware/false-true")
     *
     * @Middlewares({
     *     "Tests\Middleware\ExampleFalse",
     *     "Tests\Middleware\ExampleTrue"
     * })
     */
    public function multiple2()
    {
    }
}
