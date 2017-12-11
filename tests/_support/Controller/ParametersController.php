<?php

namespace Controller;

use Sid\Framework\Controller;
use Sid\Framework\Router\Route\Uri;
use Sid\Framework\Router\Route\Requirements;

class ParametersController extends Controller
{
    /**
     * @Uri("/parameters/{name}")
     */
    public function a($name)
    {
    }

    /**
     * @Uri("/parameters/{name}/{id}")
     *
     * @Requirements(
     *     id="\d+"
     * )
     */
    public function b($name, $id)
    {
    }

    /**
     * @Uri("/parameters/{name}/{id}/{date}")
     *
     * @Requirements(
     *     id="\d+",
     *     date="[0-9\-]+"
     * )
     */
    public function c($name, $id, $date)
    {
    }
}
