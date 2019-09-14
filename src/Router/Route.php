<?php

namespace Sid\Framework\Router;

use Sid\Framework\Dispatcher\Path;
use Sid\Framework\Router\Route\Converters;
use Sid\Framework\Router\Route\Method;
use Sid\Framework\Router\Route\Middlewares;
use Sid\Framework\Router\Route\Requirements;
use Sid\Framework\Router\Route\Uri;

class Route
{
    /**
     * @var Uri
     */
    protected $uri;

    /**
     * @var Method
     */
    protected $method;

    /**
     * @var Path
     */
    protected $path;

    /**
     * @var Requirements
     */
    protected $requirements;

    /**
     * @var Middlewares
     */
    protected $middlewares;

    /**
     * @var Converters
     */
    protected $converters;

    protected $compiledPattern;



    public function __construct(
        Uri $uri,
        Path $path,
        Method $method = null,
        Requirements $requirements = null,
        Middlewares $middlewares = null,
        Converters $converters = null
    ) {
        $this->uri          = $uri;
        $this->path         = $path;
        $this->method       = $method ?: new Method(["value" => "GET"]);
        $this->requirements = $requirements ?: new Requirements([]);
        $this->middlewares  = $middlewares ?: new Middlewares([]);
        $this->converters   = $converters ?: new Converters([]);

        $this->createCompiledPattern();
    }



    public function getUri() : Uri
    {
        return $this->uri;
    }

    public function getPath() : Path
    {
        return $this->path;
    }

    public function getMethod() : Method
    {
        return $this->method;
    }

    public function getRequirements() : Requirements
    {
        return $this->requirements;
    }

    public function getMiddlewares() : Middlewares
    {
        return $this->middlewares;
    }

    public function getConverters() : Converters
    {
        return $this->converters;
    }

    public function getCompiledPattern()
    {
        return $this->compiledPattern;
    }




    protected function createCompiledPattern()
    {
        $pattern = $this->getUri()->getUri();

        // Get parameter names from URI.
        preg_match_all(
            "/\{([A-Za-z]+)\}/",
            $pattern,
            $matches
        );

        $params = array_flip(
            $matches[1]
        );

        // Assume every parameter has no requirement - any value is allowed.
        foreach ($params as $key => $value) {
            $params[$key] = "[^/]+";
        }

        // Merge with the requirements.
        $params = array_merge(
            $params,
            $this->requirements->toArray()
        );

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
