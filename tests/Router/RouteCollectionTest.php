<?php

namespace Sid\Framework\Test\Unit\Router;

use Codeception\TestCase\Test;
use Doctrine\Common\Annotations\AnnotationReader;
use Sid\Framework\Router\RouteCollection;

class RouteCollectionTest extends Test
{
    public function testAddController()
    {
        $annotations = new AnnotationReader();

        $routeCollection = new RouteCollection($annotations);

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
            \Controller\ParametersController::class
        );

        $this->assertEquals(
            4,
            count($routeCollection->getRoutes())
        );
    }

    public function testAddControllers()
    {
        $annotations = new AnnotationReader();

        $routeCollection = new RouteCollection($annotations);

        $this->assertEquals(
            0,
            count($routeCollection->getRoutes())
        );

        $routeCollection->addControllers(
            [
                \Controller\IndexController::class,
                \Controller\ParametersController::class,
            ]
        );

        $this->assertEquals(
            4,
            count($routeCollection->getRoutes())
        );
    }

    /**
     * @expectedException \Sid\Framework\Router\Exception\ControllerNotFoundException
     */
    public function testControllerNotFoundException()
    {
        $annotations = new AnnotationReader();

        $routeCollection = new RouteCollection($annotations);

        $routeCollection->addController(
            "A\Class\That\Does\Not\Exist"
        );
    }

    /**
     * @expectedException \Sid\Framework\Router\Exception\NotAControllerException
     */
    public function testNotAControllerException()
    {
        $annotations = new AnnotationReader();

        $routeCollection = new RouteCollection($annotations);

        $routeCollection->addController(
            \Sid\Framework\Router::class
        );
    }
}
