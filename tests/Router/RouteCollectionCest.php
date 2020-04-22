<?php

namespace Tests\Router;

use Doctrine\Common\Annotations\AnnotationReader;
use Sid\Framework\Router;
use Sid\Framework\Router\Exception\ControllerNotFoundException;
use Sid\Framework\Router\Exception\NotAControllerException;
use Sid\Framework\Router\Exception\NotAnActionMethodException;
use Sid\Framework\Router\RouteCollection;
use Tests\Controller\BadActionMethodController;
use Tests\Controller\IndexController;
use Tests\Controller\ParametersController;
use Tests\UnitTester;

class RouteCollectionCest
{
    public function addController(UnitTester $I)
    {
        $annotations = new AnnotationReader();

        $routeCollection = new RouteCollection($annotations);

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
            ParametersController::class
        );

        $I->assertCount(
            4,
            $routeCollection->getRoutes()
        );
    }

    public function addControllers(UnitTester $I)
    {
        $annotations = new AnnotationReader();

        $routeCollection = new RouteCollection($annotations);

        $I->assertCount(
            0,
            $routeCollection->getRoutes()
        );

        $routeCollection->addControllers(
            [
                IndexController::class,
                ParametersController::class,
            ]
        );

        $I->assertCount(
            4,
            $routeCollection->getRoutes()
        );
    }

    public function controllerNotFoundException(UnitTester $I)
    {
        $annotations = new AnnotationReader();

        $routeCollection = new RouteCollection($annotations);



        $I->expectThrowable(
            ControllerNotFoundException::class,
            function () use ($routeCollection) {
                $routeCollection->addController(
                    "A\\Class\\That\\Does\\Not\\Exist"
                );
            }
        );
    }

    public function notAControllerException(UnitTester $I)
    {
        $annotations = new AnnotationReader();

        $routeCollection = new RouteCollection($annotations);



        $I->expectThrowable(
            NotAControllerException::class,
            function () use ($routeCollection) {
                $routeCollection->addController(
                    Router::class
                );
            }
        );
    }

    public function notAValidActionMethodException(UnitTester $I)
    {
        $annotations = new AnnotationReader();

        $routeCollection = new RouteCollection($annotations);



        $I->expectThrowable(
            NotAnActionMethodException::class,
            function () use ($routeCollection) {
                $routeCollection->addController(
                    BadActionMethodController::class
                );
            }
        );
    }
}
