<?php

namespace Controller;

use Sid\Framework\Controller;

use Sid\Framework\Router\Annotations\Route;

class ParametersController extends Controller
{
    /**
     * @Route(
     *     "/parameters/{name}"
     * )
     */
    public function a($name)
    {
    }

    /**
     * @Route(
     *     "/parameters/{name}/{id}",
     *     requirements={
     *         "id"="\d+"
     *     }
     * )
     */
    public function b($name, $id)
    {
    }

    /**
     * @Route(
     *     "/parameters/{name}/{id}/{date}",
     *     requirements={
     *         "id"="\d+",
     *         "date"="[0-9\-]+"
     *     }
     * )
     */
    public function c($name, $id, $date)
    {
    }
}
