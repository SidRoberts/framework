<?php

namespace Tests;

use Codeception\Example;
use Doctrine\Common\Annotations\AnnotationReader;
use Sid\ContainerResolver\Resolver\Psr11 as Resolver;
use Sid\Framework\Router;
use Sid\Framework\Router\Exception\RouteNotFoundException;
use Sid\Framework\Router\Route;
use Sid\Framework\Router\RouteCollection;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Request;
use Tests\Controller\ConverterController;
use Tests\Controller\HttpMethodController;
use Tests\Controller\IndexController;
use Tests\Controller\MiddlewareController;
use Tests\Controller\RequirementsController;

class RouterCest
{
    public function testGetRouteCollection(UnitTester $I)
    {
        $container = new Container();

        $resolver = new Resolver($container);



        $annotations = new AnnotationReader();

        $routeCollection = new RouteCollection($annotations);



        $router = new Router($resolver, $routeCollection);

        $I->assertEquals(
            $routeCollection,
            $router->getRouteCollection()
        );
    }

    public function testConverters(UnitTester $I)
    {
        $container = new Container();

        $resolver = new Resolver($container);



        $annotations = new AnnotationReader();

        $routeCollection = new RouteCollection($annotations);



        $routeCollection->addController(
            ConverterController::class
        );



        $router = new Router($resolver, $routeCollection);

        $match = $router->handle("/converter/double/123", "GET");

        $I->assertEquals(
            246,
            $match->getParams()->get("i")
        );
    }

    /**
     * @dataProvider middlewaresProvider
     */
    public function testMiddlewares(UnitTester $I, Example $example)
    {
        $container = new Container();

        $resolver = new Resolver($container);



        $annotations = new AnnotationReader();

        $routeCollection = new RouteCollection($annotations);



        $routeCollection->addController(
            MiddlewareController::class
        );



        $router = new Router($resolver, $routeCollection);



        try {
            $match = $router->handle($example["url"], "GET");

            $I->assertTrue($example["shouldPass"]);
        } catch (RouteNotFoundException $e) {
            $I->assertFalse($example["shouldPass"]);
        }
    }

    public function middlewaresProvider() : array
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
    public function testRequirements(UnitTester $I, Example $example)
    {
        $container = new Container();

        $resolver = new Resolver($container);



        $annotations = new AnnotationReader();

        $routeCollection = new RouteCollection($annotations);



        $routeCollection->addController(
            RequirementsController::class
        );



        $router = new Router($resolver, $routeCollection);



        try {
            $match = $router->handle($example["url"], "GET");

            $I->assertTrue($example["shouldPass"]);
        } catch (RouteNotFoundException $e) {
            $I->assertFalse($example["shouldPass"]);
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

    public function testRouteNotFoundException(UnitTester $I)
    {
        $container = new Container();

        $resolver = new Resolver($container);



        $annotations = new AnnotationReader();

        $routeCollection = new RouteCollection($annotations);



        $router = new Router($resolver, $routeCollection);



        $I->expectException(
            RouteNotFoundException::class,
            function () use ($router) {
                $router->handle("/this/is/a/route/that/doesnt/exist", "GET");
            }
        );
    }

    public function testHttpMethods(UnitTester $I)
    {
        $container = new Container();

        $resolver = new Resolver($container);



        $annotations = new AnnotationReader();

        $routeCollection = new RouteCollection($annotations);



        $routeCollection->addController(
            HttpMethodController::class
        );



        $router = new Router($resolver, $routeCollection);



        $getMatch = $router->handle("/", "GET");

        $I->assertEquals(
            "get",
            $getMatch->getPath()->getAction()
        );



        $postMatch = $router->handle("/", "POST");

        $I->assertEquals(
            "post",
            $postMatch->getPath()->getAction()
        );
    }

    public function testGetRoutes(UnitTester $I)
    {
        $container = new Container();

        $resolver = new Resolver($container);



        $annotations = new AnnotationReader();

        $routeCollection = new RouteCollection($annotations);



        $router = new Router($resolver, $routeCollection);


        $I->assertCount(
            0,
            $routeCollection->getRoutes()
        );



        $routeCollection->addController(
            IndexController::class
        );

        $I->assertCount(
            1,
            $routeCollection->getRoutes()
        );



        $routeCollection->addController(
            RequirementsController::class
        );

        $I->assertCount(
            2,
            $routeCollection->getRoutes()
        );



        $routes = $routeCollection->getRoutes();

        foreach ($routes as $route) {
            $I->assertInstanceOf(
                Route::class,
                $route
            );
        }
    }
}
