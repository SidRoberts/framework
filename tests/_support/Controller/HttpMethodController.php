<?php

namespace Controller;

use Sid\Framework\Controller;
use Sid\Framework\Router\Route\Uri;
use Sid\Framework\Router\Route\Method;

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
