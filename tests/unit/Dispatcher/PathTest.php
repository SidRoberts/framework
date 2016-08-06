<?php

namespace Sid\Framework\Test\Unit\Dispatcher;

use Sid\Framework\Dispatcher\Path;

class PathTest extends \Codeception\TestCase\Test
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }



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

    /**
     * @expectedException \Sid\Framework\Dispatcher\Exception\ControllerNotFoundException
     */
    public function testControllerNotFoundException()
    {
        $controller = "FakeController";
        $action     = "index";

        $path = new Path(
            $controller,
            $action
        );
    }

    /**
     * @expectedException \Sid\Framework\Dispatcher\Exception\ActionNotFoundException
     */
    public function testActionNotFoundException()
    {
        $controller = \Controller\IndexController::class;
        $action     = "fake";

        $path = new Path(
            $controller,
            $action
        );
    }
}
