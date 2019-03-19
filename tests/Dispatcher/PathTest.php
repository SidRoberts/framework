<?php

namespace Sid\Framework\Test\Unit\Dispatcher;

use Codeception\TestCase\Test;
use Sid\Framework\Dispatcher\Path;
use Sid\Framework\Dispatcher\Exception\ControllerNotFoundException;
use Sid\Framework\Dispatcher\Exception\ActionNotFoundException;

class PathTest extends Test
{
    public function testGetters()
    {
        $controller = \Controller\IndexController::class;
        $action     = "index";



        $path = new Path(
            $controller,
            $action
        );



        $this->assertEquals(
            $controller,
            $path->getController()
        );

        $this->assertEquals(
            $action,
            $path->getAction()
        );
    }

    public function testControllerNotFoundException()
    {
        $this->expectException(
            ControllerNotFoundException::class
        );



        $controller = "FakeController";
        $action     = "index";

        $path = new Path(
            $controller,
            $action
        );
    }

    public function testActionNotFoundException()
    {
        $this->expectException(
            ActionNotFoundException::class
        );



        $controller = \Controller\IndexController::class;
        $action     = "fake";

        $path = new Path(
            $controller,
            $action
        );
    }
}
