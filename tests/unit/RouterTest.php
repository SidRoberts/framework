<?php

namespace Sid\Framework\Test\Unit;

use Symfony\Component\DependencyInjection\ContainerBuilder;

use Sid\Framework\Resolver;

use Sid\Framework\Router;
use Sid\Framework\Router\Route;
use Sid\Framework\Router\RouteCollection;

use Sid\Framework\Router\Exception\RouteNotFoundException;

use Symfony\Component\HttpFoundation\Request;

class RouterTest extends \Codeception\TestCase\Test
{
    public function testGetRouteCollection()
    {
        $container = new ContainerBuilder();

        $resolver = new Resolver($container);



        $annotations = new \Doctrine\Common\Annotations\AnnotationReader();

        $routeCollection = new RouteCollection($annotations);



        $router = new Router($resolver, $routeCollection);

        $this->assertEquals(
            $routeCollection,
            $router->getRouteCollection()
        );
    }

    public function testConverters()
    {
        $container = new ContainerBuilder();

        $resolver = new Resolver($container);



        $annotations = new \Doctrine\Common\Annotations\AnnotationReader();

        $routeCollection = new RouteCollection($annotations);



        $routeCollection->addController(
            \Controller\ConverterController::class
        );



        $router = new Router($resolver, $routeCollection);

        $match = $router->handle("/converter/double/123", "GET");

        $this->assertEquals(
            246,
            $match->getParams()["i"]
        );
    }

    /**
     * @dataProvider middlewaresProvider
     */
    public function testMiddlewares($url, $shouldPass)
    {
        $container = new ContainerBuilder();

        $resolver = new Resolver($container);



        $annotations = new \Doctrine\Common\Annotations\AnnotationReader();

        $routeCollection = new RouteCollection($annotations);



        $routeCollection->addController(
            \Controller\MiddlewareController::class
        );



        $router = new Router($resolver, $routeCollection);



        try {
            $match = $router->handle($url, "GET");

            $this->assertTrue($shouldPass);
        } catch (RouteNotFoundException $e) {
            $this->assertFalse($shouldPass);
        }
    }

    public function middlewaresProvider()
    {
        return [
            [
                "url"        => "/middleware/true",
                "shouldPass" => true,
            ],

            [
                "url"        => "/middleware/false",
                "shouldPass" => false,
            ],

            [
                "url"        => "/middleware/true-false",
                "shouldPass" => false,
            ],

            [
                "url"        => "/middleware/false-true",
                "shouldPass" => false,
            ],
        ];
    }

    /**
     * @dataProvider requirementsProvider
     */
    public function testRequirements($url, $shouldPass)
    {
        $container = new ContainerBuilder();

        $resolver = new Resolver($container);



        $annotations = new \Doctrine\Common\Annotations\AnnotationReader();

        $routeCollection = new RouteCollection($annotations);



        $routeCollection->addController(
            \Controller\RequirementsController::class
        );



        $router = new Router($resolver, $routeCollection);



        try {
            $match = $router->handle($url, "GET");

            $this->assertTrue($shouldPass);
        } catch (RouteNotFoundException $e) {
            $this->assertFalse($shouldPass);
        }
    }

    public function requirementsProvider()
    {
        return [
            [
                "url"        => "/requirements/123",
                "shouldPass" => true,
            ],

            [
                "url"        => "/requirements/hello",
                "shouldPass" => false,
            ],

            [
                "url"        => "/requirements/123.456",
                "shouldPass" => false,
            ],
        ];
    }

    /**
     * @expectedException \Sid\Framework\Router\Exception\RouteNotFoundException
     */
    public function testRouteNotFoundException()
    {
        $container = new ContainerBuilder();

        $resolver = new Resolver($container);



        $annotations = new \Doctrine\Common\Annotations\AnnotationReader();

        $routeCollection = new RouteCollection($annotations);



        $router = new Router($resolver, $routeCollection);

        $router->handle("/this/is/a/route/that/doesnt/exist", "GET");
    }

    public function testHttpMethods()
    {
        $container = new ContainerBuilder();

        $resolver = new Resolver($container);



        $annotations = new \Doctrine\Common\Annotations\AnnotationReader();

        $routeCollection = new RouteCollection($annotations);



        $routeCollection->addController(
            \Controller\HttpMethodController::class
        );



        $router = new Router($resolver, $routeCollection);



        $getMatch = $router->handle("/", "GET");

        $this->assertEquals(
            "get",
            $getMatch->getPath()->getAction()
        );



        $postMatch = $router->handle("/", "POST");

        $this->assertEquals(
            "post",
            $postMatch->getPath()->getAction()
        );
    }

    public function testGetRoutes()
    {
        $container = new ContainerBuilder();

        $resolver = new Resolver($container);



        $annotations = new \Doctrine\Common\Annotations\AnnotationReader();

        $routeCollection = new RouteCollection($annotations);



        $router = new Router($resolver, $routeCollection);


        $this->assertEquals(
            0,
            count($routeCollection->getRoutes())
        );



        $routeCollection->addController(
            \Controller\IndexController::class
        );

        $this->assertEquals(
            1,
            count($routeCollection->getRoutes())
        );



        $routeCollection->addController(
            \Controller\RequirementsController::class
        );

        $this->assertEquals(
            2,
            count($routeCollection->getRoutes())
        );



        $routes = $routeCollection->getRoutes();

        foreach ($routes as $route) {
            $this->assertInstanceOf(
                Route::class,
                $route
            );
        }
    }
}
