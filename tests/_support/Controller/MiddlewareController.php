<?php

namespace Controller;

use Sid\Framework\Controller;

use Sid\Framework\Router\Annotations\Route;

class MiddlewareController extends Controller
{
    /**
     * @Route(
     *     "/middleware/true",
     *     middlewares={
     *         "Middleware\ExampleTrue"
     *     }
     * )
     */
    public function true()
    {
    }

    /**
     * @Route(
     *     "/middleware/false",
     *     middlewares={
     *         "Middleware\ExampleFalse"
     *     }
     * )
     */
    public function false()
    {
    }

    /**
     * @Route(
     *     "/middleware/true-false",
     *     middlewares={
     *         "Middleware\ExampleTrue",
     *         "Middleware\ExampleFalse"
     *     }
     * )
     */
    public function multiple1()
    {
    }

    /**
     * @Route(
     *     "/middleware/false-true",
     *     middlewares={
     *         "Middleware\ExampleFalse",
     *         "Middleware\ExampleTrue"
     *     }
     * )
     */
    public function multiple2()
    {
    }
}
