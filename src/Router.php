<?php

namespace Sid\Framework;

use Sid\Container\Container;

use Sid\Framework\Middleware\Runner as MiddlewareRunner;

use Sid\Framework\Router\Annotations\Route as RouteAnnotation;
use Sid\Framework\Router\Exception\RouteNotFoundException;
use Sid\Framework\Router\Match;
use Sid\Framework\Router\Route;
use Sid\Framework\Router\RouteCollection;

class Router
{
    /**
     * @var Container
     */
    protected $container;

    /**
     * @var RouteCollection
     */
    protected $routeCollection;



    public function __construct(Container $container, RouteCollection $routeCollection)
    {
        $this->container       = $container;
        $this->routeCollection = $routeCollection;
    }



    public function getRouteCollection() : RouteCollection
    {
        return $this->routeCollection;
    }



    public function handle(string $uri, string $method) : Match
    {
        // Remove redundant slashes.
        $uri = "/" . trim($uri, "/");

        // Remove parameters from URI.
        $uri = explode("?", $uri)[0];



        $routeFound = false;
        $params = [];



        $routes = $this->routeCollection->getRoutes();

        foreach ($routes as $route) {
            $routeAnnotation = $route->getRouteAnnotation();



            // Check if the current HTTP method is allowed by the route.
            if ($routeAnnotation->getMethod() !== $method) {
                continue;
            }



            $pattern = $routeAnnotation->getCompiledPattern();

            $routeFound = (preg_match($pattern, $uri, $params) === 1);

            if ($routeFound) {
                if ($this->runMiddlewares($route, $uri)) {
                    break;
                } else {
                    $routeFound = false;

                    continue;
                }
            }
        }



        if (!$routeFound) {
            throw new RouteNotFoundException();
        }



        // Remove integer keys from params.
        $params = array_filter(
            $params,
            function ($value, $key) {
                return !is_int($key);
            },
            ARRAY_FILTER_USE_BOTH
        );


        $path = $route->getPath();

        $params = $this->convertParams($route, $params);

        return new Match(
            $path,
            $params
        );
    }



    protected function runMiddlewares(Route $route, string $uri) : bool
    {
        $routeAnnotation = $route->getRouteAnnotation();

        $middlewares = $routeAnnotation->getMiddlewares();



        $middlewareRunner = new MiddlewareRunner();

        foreach ($middlewares as $middleware) {
            $middlewareRunner->addMiddleware(
                $this->container->typehintClass($middleware)
            );
        }

        return $middlewareRunner->run(
            [
                $uri,
                $route,
            ]
        );
    }



    protected function convertParams(Route $route, array $params) : array
    {
        $routeAnnotation = $route->getRouteAnnotation();



        $converters = $routeAnnotation->getConverters();

        foreach ($params as $key => $value) {
            // Check if the part has a converter.
            if (!isset($converters[$key])) {
                continue;
            }

            $converter = $converters[$key];

            $params[$key] = call_user_func_array(
                [
                    $this->container->typehintClass($converter),
                    "convert",
                ],
                [
                    $value
                ]
            );
        }

        return $params;
    }
}
