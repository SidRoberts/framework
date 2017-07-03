<?php

namespace Sid\Framework\Test\Unit;

use Symfony\Component\DependencyInjection\ContainerBuilder;

use Sid\Framework\Kernel;
use Sid\Framework\Dispatcher;
use Sid\Framework\Resolver;
use Sid\Framework\Router;
use Sid\Framework\Router\RouteCollection;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Sid\Framework\Kernel\KernelEvents;

class KernelTest extends \Codeception\TestCase\Test
{
    public function testBasicHandle()
    {
        $container = new ContainerBuilder();

        $resolver = new Resolver($container);



        $annotations = new \Doctrine\Common\Annotations\AnnotationReader();

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



        $returnedValue = $kernel->handle($request);

        $this->assertEquals(
            "homepage",
            $returnedValue
        );
    }

    public function testReturnHandler()
    {
        $container = new ContainerBuilder();

        $resolver = new Resolver($container);



        $annotations = new \Doctrine\Common\Annotations\AnnotationReader();

        $routeCollection = new RouteCollection($annotations);



        $routeCollection->addController(
            \Controller\IndexController::class
        );



        $router = new Router($resolver, $routeCollection);
        $dispatcher = new Dispatcher($resolver);

        $kernel = new Kernel($router, $dispatcher);


        $kernel->addReturnHandler(
            new \Sid\Framework\Kernel\ReturnHandler\Response()
        );



        $request = Request::create(
            "/",
            "GET"
        );



        $response = $kernel->handle($request);



        $this->assertInstanceof(
            Response::class,
            $response
        );

        $this->assertEquals(
            "homepage",
            $response->getContent()
        );
    }

    public function testGetAndSetNotFoundPath()
    {
        $container = new ContainerBuilder();

        $resolver = new Resolver($container);



        $annotations = new \Doctrine\Common\Annotations\AnnotationReader();

        $routeCollection = new RouteCollection($annotations);



        $routeCollection->addController(
            \Controller\ErrorController::class
        );



        $router = new Router($resolver, $routeCollection);
        $dispatcher = new Dispatcher($resolver);

        $kernel = new Kernel($router, $dispatcher);



        $notFoundPath = new \Sid\Framework\Dispatcher\Path(
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
        $container = new ContainerBuilder();

        $resolver = new Resolver($container);



        $annotations = new \Doctrine\Common\Annotations\AnnotationReader();

        $routeCollection = new RouteCollection($annotations);



        $router = new Router($resolver, $routeCollection);
        $dispatcher = new Dispatcher($resolver);

        $kernel = new Kernel($router, $dispatcher);



        $notFoundPath = new \Sid\Framework\Dispatcher\Path(
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
        $dispatcher = new Dispatcher($resolver);

        $kernel = new Kernel($router, $dispatcher);



        $request = Request::create(
            "/this/route/does/not/exist",
            "GET"
        );

        $response = $kernel->handle($request);
    }
}
