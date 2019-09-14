<?php

namespace Sid\Framework;

use Sid\ContainerResolver\ResolverInterface;
use Sid\Framework\Middleware\Runner as MiddlewareRunner;
use Sid\Framework\Router\Exception\RouteNotFoundException;
use Sid\Framework\Router\Match;
use Sid\Framework\Router\Route;
use Sid\Framework\Router\Route\Uri;
use Sid\Framework\Router\RouteCollection;

class Router implements RouterInterface
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
        // Remove parameters from URI.
        $uri = explode("?", $uri)[0];

        // Remove redundant slashes.
        $uri = "/" . trim($uri, "/");



        $routeFound = false;
        $params = [];



        $routes = $this->routeCollection->getRoutes();

        foreach ($routes as $route) {
            $methodClass = $route->getMethod();

            $pattern = $route->getCompiledPattern();



            $routeFound =
                // Check if the current HTTP method is allowed by the route.
                ($methodClass->getMethod() === $method)
                &&
                (preg_match($pattern, $uri, $params) === 1)
                &&
                $this->runMiddlewares($route, $uri);

            if ($routeFound) {
                break;
            }
        }



        if (!$routeFound) {
            throw new RouteNotFoundException(
                sprintf(
                    "None of the routes match the path '%s %s'",
                    $method,
                    $uri
                )
            );
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
        $middlewares = $route->getMiddlewares();

        $middlewareRunner = new MiddlewareRunner();

        foreach ($middlewares as $middlewareName) {
            $middleware = $this->resolver->typehintClass($middlewareName);

            $middlewareRunner->addMiddleware($middleware);
        }

        return $middlewareRunner->run($uri, $route);
    }



    protected function convertParams(Route $route, array $params) : array
    {
        $converters = $route->getConverters();

        foreach ($params as $key => $value) {
            // Check if the part has a converter.
            if (!isset($converters[$key])) {
                continue;
            }

            $converterName = $converters[$key];

            $converter = $this->resolver->typehintClass($converterName);

            $params[$key] = $converter->convert($value);
        }

        return $params;
    }
}
