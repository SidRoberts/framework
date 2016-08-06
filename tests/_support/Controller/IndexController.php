<?php

namespace Controller;

use Sid\Framework\Controller;

use Sid\Framework\Router\Annotations\Route;

class IndexController extends Controller
{
    /**
     * @Route(
     *     "/"
     * )
     */
    public function index()
    {
    	return "homepage";
    }
}
