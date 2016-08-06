<?php

namespace Controller;

use Sid\Framework\Controller;

use Sid\Framework\Router\Annotations\Route;

class HttpMethodController extends Controller
{
    /**
     * @Route(
     *     "/",
     *     method="GET"
     * )
     */
    public function get()
    {
    }

    /**
     * @Route(
     *     "/",
     *     method="POST"
     * )
     */
    public function post()
    {
    }
}
