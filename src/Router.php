<?php

namespace Sid\Framework;

use Sid\Framework\Middleware\Runner as MiddlewareRunner;

use Sid\Framework\Router\Annotations\Route as RouteAnnotation;
use Sid\Framework\Router\Exception\RouteNotFoundException;
use Sid\Framework\Router\Match;
use Sid\Framework\Router\Route;
use Sid\Framework\Router\RouteCollection;

class Router
{
    /**
     * @var ResolverInterface
     */
    protected $resolver;

    /**
     * @var RouteCollection
     */
    protected $routeCollection;



    public function __construct(ResolverInterface $resolver, RouteCollection $routeCollection)
    {
        $this->resolver        = $resolver;
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

            if (!$routeFound) {
                continue;
            }

            if ($this->runMiddlewares($route, $uri)) {
                break;
            } else {
                $routeFound = false;

                continue;
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

        foreach ($middlewares as $middlewareName) {
            $middleware = $this->resolveMiddleware($middlewareName);

            $middlewareRunner->addMiddleware($middleware);
        }

        return $middlewareRunner->run(
            [
                $uri,
                $route,
            ]
        );
    }

    protected function resolveMiddleware(string $middlewareName)
    {
        $middleware = $this->resolver->typehintClass($middlewareName);

        return $middleware;
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

            $converterName = $converters[$key];

            $converter = $this->resolveConverter($converterName);

            $params[$key] = call_user_func_array(
                [
                    $converter,
                    "convert",
                ],
                [
                    $value
                ]
            );
        }

        return $params;
    }

    protected function resolveConverter(string $converterName)
    {
        $converter = $this->resolver->typehintClass($converterName);

        return $converter;
    }
}
