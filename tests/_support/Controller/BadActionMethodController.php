<?php

namespace Tests\Controller;

use Sid\Framework\Controller;

class BadActionMethodController extends Controller
{
    /*
     * This action doesn't have a Uri annotation.
     */
    public function index()
    {
        return "homepage";
    }
}
