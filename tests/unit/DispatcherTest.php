<?php

namespace Sid\Framework\Test\Unit;

use Sid\Container\Container;

use Sid\Framework\Dispatcher;
use Sid\Framework\Dispatcher\Path;

class DispatcherTest extends \Codeception\TestCase\Test
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



    public function testSimpleDispatch()
    {
        $container = new Container();

        $dispatcher = new Dispatcher($container);



        $returnedValue = $dispatcher->dispatch(
            new Path(
                \Controller\IndexController::class,
                "index"
            )
        );

        $this->assertEquals(
            "homepage",
            $returnedValue
        );
    }

    public function testParams()
    {
        $container = new Container();

        $dispatcher = new Dispatcher($container);



        $returnedValue = $dispatcher->dispatch(
            new Path(
                \Controller\MathController::class,
                "addition"
            ),
            [
                2,
                "3"
            ]
        );

        $this->assertEquals(
            5,
            $returnedValue
        );
    }
}
