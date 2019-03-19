<?php

namespace Sid\Framework\Test\Unit;

use Codeception\TestCase\Test;

use Doctrine\Common\Annotations\AnnotationReader;

use Sid\ContainerResolver\Resolver\Psr11 as Resolver;

use Sid\Framework\Kernel;
use Sid\Framework\Dispatcher;
use Sid\Framework\Dispatcher\Path;
use Sid\Framework\Router;
use Sid\Framework\Router\Exception\RouteNotFoundException;
use Sid\Framework\Router\RouteCollection;

use Symfony\Component\DependencyInjection\Container;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class KernelTest extends Test
{
    public function testBasicHandle()
    {
        $container = new Container();

        $resolver = new Resolver($container);



        $annotations = new AnnotationReader();

        $routeCollection = new RouteCollection($annotations);



        $routeCollection->addController(
            \Controller\IndexController::class
        );



        $router = new Router($resolver, $routeCollection);
        $dispatcher = new Dispatcher($resolver);

        $kernel = new Kernel($router, $dispatcher);



        $request = Request::create(
            "/",
            "GET"
        );



        $response = $kernel->handle($request);

        $this->assertEquals(
            "homepage",
            $response->getContent()
        );
    }

    public function testGetAndSetNotFoundPath()
    {
        $container = new Container();

        $resolver = new Resolver($container);



        $annotations = new AnnotationReader();

        $routeCollection = new RouteCollection($annotations);



        $routeCollection->addController(
            \Controller\ErrorController::class
        );



        $router = new Router($resolver, $routeCollection);
        $dispatcher = new Dispatcher($resolver);

        $kernel = new Kernel($router, $dispatcher);



        $notFoundPath = new Path(
            \Controller\ErrorController::class,
            "notFound"
        );



        $this->assertNull(
            $kernel->getNotFoundPath()
        );

        $kernel->setNotFoundPath(
            $notFoundPath
        );

        $this->assertEquals(
            $notFoundPath,
            $kernel->getNotFoundPath()
        );
    }

    public function testNotFoundPath()
    {
        $container = new Container();

        $resolver = new Resolver($container);



        $annotations = new AnnotationReader();

        $routeCollection = new RouteCollection($annotations);



        $router = new Router($resolver, $routeCollection);
        $dispatcher = new Dispatcher($resolver);

        $kernel = new Kernel($router, $dispatcher);



        $notFoundPath = new Path(
            \Controller\ErrorController::class,
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



        $this->assertEquals(
            "not found",
            $response->getContent()
        );
    }

    public function testRouteNotFoundException()
    {
        $this->expectException(
            RouteNotFoundException::class
        );



        $container = new Container();

        $resolver = new Resolver($container);



        $annotations = new AnnotationReader();

        $routeCollection = new RouteCollection($annotations);



        $router = new Router($resolver, $routeCollection);
        $dispatcher = new Dispatcher($resolver);

        $kernel = new Kernel($router, $dispatcher);



        $request = Request::create(
            "/this/route/does/not/exist",
            "GET"
        );

        $response = $kernel->handle($request);
    }
}
