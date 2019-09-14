<?php

namespace Tests;

use Doctrine\Common\Annotations\AnnotationReader;
use Sid\ContainerResolver\Resolver\Psr11 as Resolver;
use Sid\Framework\Dispatcher;
use Sid\Framework\Dispatcher\Path;
use Sid\Framework\Kernel;
use Sid\Framework\Router;
use Sid\Framework\Router\Exception\RouteNotFoundException;
use Sid\Framework\Router\RouteCollection;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Request;
use Tests\Controller\ErrorController;
use Tests\Controller\IndexController;

class KernelCest
{
    public function basicHandle(UnitTester $I)
    {
        $container = new Container();

        $resolver = new Resolver($container);



        $annotations = new AnnotationReader();

        $routeCollection = new RouteCollection($annotations);



        $routeCollection->addController(
            IndexController::class
        );



        $router = new Router($resolver, $routeCollection);
        $dispatcher = new Dispatcher($resolver);

        $kernel = new Kernel($router, $dispatcher);



        $request = Request::create(
            "/",
            "GET"
        );



        $response = $kernel->handle($request);

        $I->assertEquals(
            "homepage",
            $response->getContent()
        );
    }

    public function getAndSetNotFoundPath(UnitTester $I)
    {
        $container = new Container();

        $resolver = new Resolver($container);



        $annotations = new AnnotationReader();

        $routeCollection = new RouteCollection($annotations);



        $routeCollection->addController(
            ErrorController::class
        );



        $router = new Router($resolver, $routeCollection);
        $dispatcher = new Dispatcher($resolver);

        $kernel = new Kernel($router, $dispatcher);



        $notFoundPath = new Path(
            ErrorController::class,
            "notFound"
        );



        $I->assertNull(
            $kernel->getNotFoundPath()
        );

        $kernel->setNotFoundPath(
            $notFoundPath
        );

        $I->assertEquals(
            $notFoundPath,
            $kernel->getNotFoundPath()
        );
    }

    public function notFoundPath(UnitTester $I)
    {
        $container = new Container();

        $resolver = new Resolver($container);



        $annotations = new AnnotationReader();

        $routeCollection = new RouteCollection($annotations);



        $router = new Router($resolver, $routeCollection);
        $dispatcher = new Dispatcher($resolver);

        $kernel = new Kernel($router, $dispatcher);



        $notFoundPath = new Path(
            ErrorController::class,
            "notFound"
        );

        $kernel->setNotFoundPath(
            $notFoundPath
        );



        $request = Request::create(
            "/this/route/does/not/exist",
            "GET"
        );

        $response = $kernel->handle($request);



        $I->assertEquals(
            "not found",
            $response->getContent()
        );
    }

    public function routeNotFoundException(UnitTester $I)
    {
        $container = new Container();

        $resolver = new Resolver($container);



        $annotations = new AnnotationReader();

        $routeCollection = new RouteCollection($annotations);



        $router = new Router($resolver, $routeCollection);
        $dispatcher = new Dispatcher($resolver);

        $kernel = new Kernel($router, $dispatcher);



        $I->expectException(
            RouteNotFoundException::class,
            function () use ($kernel) {
                $request = Request::create(
                    "/this/route/does/not/exist",
                    "GET"
                );

                $response = $kernel->handle($request);
            }
        );
    }
}
