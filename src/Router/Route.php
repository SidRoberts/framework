<?php

namespace Sid\Framework\Router;

use Sid\Framework\Router\Annotations\Route as RouteAnnotation;
use Sid\Framework\Dispatcher\Path;

class Route
{
    /**
     * @var RouteAnnotation
     */
    protected $routeAnnotation;

    /**
     * @var Path
     */
    protected $path;



    public function __construct(RouteAnnotation $routeAnnotation, Path $path)
    {
        $this->routeAnnotation = $routeAnnotation;
        $this->path            = $path;
    }



    public function getRouteAnnotation() : RouteAnnotation
    {
        return $this->routeAnnotation;
    }

    public function getPath() : Path
    {
        return $this->path;
    }
}
