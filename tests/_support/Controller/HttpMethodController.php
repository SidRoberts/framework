<?php

namespace Tests\Controller;

use Sid\Framework\Controller;
use Sid\Framework\Router\Route\Method;
use Sid\Framework\Router\Route\Uri;

class HttpMethodController extends Controller
{
    /**
     * @Uri("/")
     *
     * @Method("GET")
     */
    public function get()
    {
    }

    /**
     * @Uri("/")
     *
     * @Method("POST")
     */
    public function post()
    {
    }
}
