<?php

namespace Sid\Framework\Router;

use ReflectionClass;
use ReflectionMethod;

use Sid\Framework\ControllerInterface;

use Sid\Framework\Dispatcher\Path;

use Sid\Framework\Router\Exception\ControllerNotFoundException;
use Sid\Framework\Router\Exception\NotAControllerException;
use Sid\Framework\Router\Annotations\Route as RouteAnnotation;

class RouteCollection
{
    /**
     * @var \Doctrine\Common\Annotations\Reader
     */
    protected $annotations;

    /**
     * @var array
     */
    protected $routes = [];



    public function __construct(\Doctrine\Common\Annotations\Reader $annotations)
    {
        $this->annotations = $annotations;
    }



    public function getRoutes() : array
    {
        return $this->routes;
    }



    public function addController(string $controller)
    {
        if (!class_exists($controller)) {
            throw new ControllerNotFoundException(
                $controller
            );
        }

        if (!is_subclass_of($controller, ControllerInterface::class)) {
            throw new NotAControllerException(
                $controller
            );
        }



        $actions = get_class_methods($controller);

        foreach ($actions as $action) {
            $routeAnnotation = $this->annotations->getMethodAnnotation(
                new ReflectionMethod(
                    $controller,
                    $action
                ),
                RouteAnnotation::class
            );

            // If there's no annotation then the method is not an action.
            if (!$routeAnnotation) {
                continue;
            }

            $route = new Route(
                $routeAnnotation,
                new Path(
                    $controller,
                    $action
                )
            );

            $this->routes[] = $route;
        }
    }

    public function addControllers(array $controllers)
    {
        foreach ($controllers as $controller) {
            $this->addController($controller);
        }
    }
}
