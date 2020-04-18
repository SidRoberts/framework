<?php

namespace Tests\Dispatcher;

use Sid\Framework\Dispatcher\Exception\ActionNotFoundException;
use Sid\Framework\Dispatcher\Exception\ControllerNotFoundException;
use Sid\Framework\Dispatcher\Path;
use Tests\Controller\IndexController;
use Tests\UnitTester;

class PathCest
{
    public function getters(UnitTester $I)
    {
        $controller = IndexController::class;
        $action     = "index";



        $path = new Path(
            $controller,
            $action
        );



        $I->assertEquals(
            $controller,
            $path->getController()
        );

        $I->assertEquals(
            $action,
            $path->getAction()
        );
    }

    public function controllerNotFoundException(UnitTester $I)
    {
        $I->expectThrowable(
            ControllerNotFoundException::class,
            function () {
                $controller = "FakeController";
                $action     = "index";

                $path = new Path(
                    $controller,
                    $action
                );
            }
        );
    }

    public function actionNotFoundException(UnitTester $I)
    {
        $I->expectThrowable(
            ActionNotFoundException::class,
            function () {
                $controller = IndexController::class;
                $action     = "fake";

                $path = new Path(
                    $controller,
                    $action
                );
            }
        );
    }
}
