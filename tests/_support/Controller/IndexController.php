<?php

namespace Controller;

use Sid\Framework\Controller;
use Sid\Framework\Router\Route\Uri;

class IndexController extends Controller
{
    /**
     * @Uri("/")
     */
    public function index()
    {
    	return "homepage";
    }
}
