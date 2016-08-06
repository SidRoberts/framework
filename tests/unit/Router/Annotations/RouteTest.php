<?php

namespace Sid\Framework\Test\Unit\Router\Annotations;

use Sid\Framework\Router\RouteCollection;

use Sid\Framework\Router\Route;
use Sid\Framework\Router\Annotations\Route as RouteAnnotation;

class RouteTest extends \Codeception\TestCase\Test
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
        parent::_before();
    }

    protected function _after()
    {
    }



    public function testGetters()
    {
        $uri = "/{a}/{b}";

        $requirements = [
            "a" => "[a-z]+",
            "b" => "[0-9]+",
        ];

        $method = "POST";

        $converters = [
            \Converter\Doubler::class
        ];

        $middlewares = [
            \Middleware\ExampleTrue::class
        ];

        $routeAnnotation = new RouteAnnotation(
            [
                "value"        => $uri,
                "requirements" => $requirements,
                "method"       => $method,
                "converters"   => $converters,
                "middlewares"  => $middlewares,
            ]
        );



        $this->assertEquals(
            $uri,
            $routeAnnotation->getUri()
        );

        $this->assertEquals(
            $requirements,
            $routeAnnotation->getRequirements()
        );

        $this->assertEquals(
            $method,
            $routeAnnotation->getMethod()
        );

        $this->assertEquals(
            $converters,
            $routeAnnotation->getConverters()
        );

        $this->assertEquals(
            $middlewares,
            $routeAnnotation->getMiddlewares()
        );
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testEmptyAnnotation()
    {
        $routeAnnotation = new RouteAnnotation(
            []
        );
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testBadConverter()
    {
        $routeAnnotation = new RouteAnnotation(
            [
                "value" => "/",
                "converters" => [
                    "example" => \Sid\Framework\Router::class
                ]
            ]
        );
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testBadMiddleware()
    {
        $routeAnnotation = new RouteAnnotation(
            [
                "value" => "/",
                "middlewares" => [
                    \Sid\Framework\Router::class
                ]
            ]
        );
    }
}
