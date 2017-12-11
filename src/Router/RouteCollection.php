<?php

namespace Sid\Framework\Router;

use ReflectionClass;
use ReflectionMethod;

use Sid\Framework\ControllerInterface;

use Sid\Framework\Dispatcher\Path;

use Sid\Framework\Router\Exception\ControllerNotFoundException;
use Sid\Framework\Router\Exception\NotAControllerException;
use Sid\Framework\Router\Exception\NotAnActionMethodException;
use Sid\Framework\Router\Route\Uri;
use Sid\Framework\Router\Route\Method;
use Sid\Framework\Router\Route\Requirements;
use Sid\Framework\Router\Route\Middlewares;
use Sid\Framework\Router\Route\Converters;

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
            $reflectionMethod = new ReflectionMethod(
                $controller,
                $action
            );



            $uri = $this->annotations->getMethodAnnotation(
                $reflectionMethod,
                Uri::class
            );

            // If there's no URI then the method is not an action.
            if (!$uri) {
                throw new NotAnActionMethodException(
                    $controller . "::" . $action
                );
            }

            $method = $this->annotations->getMethodAnnotation(
                $reflectionMethod,
                Method::class
            );

            $requirements = $this->annotations->getMethodAnnotation(
                $reflectionMethod,
                Requirements::class
            );

            $middlewares = $this->annotations->getMethodAnnotation(
                $reflectionMethod,
                Middlewares::class
            );

            $converters = $this->annotations->getMethodAnnotation(
                $reflectionMethod,
                Converters::class
            );

            $route = new Route(
                $uri,
                new Path(
                    $controller,
                    $action
                ),
                $method,
                $requirements,
                $middlewares,
                $converters
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
