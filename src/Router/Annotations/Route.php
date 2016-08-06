<?php

namespace Sid\Framework\Router\Annotations;

use \Sid\Framework\ConverterInterface;
use \Sid\Framework\MiddlewareInterface;

/**
 * @Annotation
 */
class Route
{
    /**
     * @var string
     */
    protected $uri = "";

    /**
     * @var array
     */
    protected $requirements = [];

    /**
     * @var string
     */
    protected $method = "GET";

    /**
     * @var array
     */
    protected $converters = [];

    /**
     * @var array
     */
    protected $middlewares = [];

    /**
     * @var string
     */
    protected $compiledPattern;



    public function __construct(array $values)
    {
        if (!isset($values["value"])) {
            throw new \InvalidArgumentException(
                "Route Annotation must specify a URL."
            );
        }

        $this->setUri(
            $values["value"]
        );

        if (isset($values["requirements"])) {
            $this->setRequirements(
                $values["requirements"]
            );
        }

        if (isset($values["method"])) {
            $this->setMethod(
                $values["method"]
            );
        }

        if (isset($values["converters"])) {
            $this->setConverters(
                $values["converters"]
            );
        }

        if (isset($values["middlewares"])) {
            $this->setMiddlewares(
                $values["middlewares"]
            );
        }



        $this->createCompiledPattern();
    }



    public function getUri() : string
    {
        return $this->uri;
    }

    public function getRequirements() : array
    {
        return $this->requirements;
    }

    public function getMethod() : string
    {
        return $this->method;
    }

    public function getConverters() : array
    {
        return $this->converters;
    }

    public function getMiddlewares() : array
    {
        return $this->middlewares;
    }

    public function getCompiledPattern() : string
    {
        return $this->compiledPattern;
    }



    protected function setUri(string $uri)
    {
        $this->uri = $uri;
    }

    protected function setRequirements(array $requirements)
    {
        $this->requirements = $requirements;
    }

    protected function setMethod(string $method)
    {
        $this->method = $method;
    }

    protected function setConverters(array $converters)
    {
        foreach ($converters as $param => $converter) {
            if (!is_subclass_of($converter, ConverterInterface::class)) {
                throw new \InvalidArgumentException(
                    "Converter must implement " . ConverterInterface::class
                );
            }

            $this->converters[$param] = $converter;
        }
    }

    protected function setMiddlewares(array $middlewares)
    {
        foreach ($middlewares as $middleware) {
            if (!is_subclass_of($middleware, MiddlewareInterface::class)) {
                throw new \InvalidArgumentException(
                    "Middleware must implement " . MiddlewareInterface::class
                );
            }

            $this->middlewares[] = $middleware;
        }
    }

    protected function createCompiledPattern()
    {
        $pattern = $this->uri;

        //TODO Explain this.
        preg_match_all("/\{([A-Za-z]+)\}/", $pattern, $matches);

        $params = array_flip($matches[1]);

        // Assume every parameter has no requirement - any value is allowed.
        foreach ($params as $key => $value) {
            $params[$key] = "[^/]+";
        }

        // Merge with the requirements.
        $params = array_merge($params, $this->requirements);

        foreach ($params as $param => $requirement) {
            $pattern = str_replace(
                "{" . $param . "}",
                "(?P<" . $param . ">" . $requirement . ")",
                $pattern
            );
        }

        $this->compiledPattern = "#^" . $pattern . "$#u";
    }
}
