<?php

namespace Sid\Framework\Test\Unit;

use Codeception\TestCase\Test;

use Symfony\Component\DependencyInjection\Container;

use Sid\ContainerResolver\Resolver\Psr11 as Resolver;

use Sid\Framework\Dispatcher;
use Sid\Framework\Dispatcher\Path;
use Sid\Framework\Parameters;

class DispatcherTest extends Test
{
    public function testSimpleDispatch()
    {
        $container = new Container();

        $resolver = new Resolver($container);



        $dispatcher = new Dispatcher($resolver);



        $returnedValue = $dispatcher->dispatch(
            new Path(
                \Controller\IndexController::class,
                "index"
            ),
            new Parameters(
                []
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

        $resolver = new Resolver($container);



        $dispatcher = new Dispatcher($resolver);



        $returnedValue = $dispatcher->dispatch(
            new Path(
                \Controller\MathController::class,
                "addition"
            ),
            new Parameters(
                [
                    "a" => 2,
                    "b" => "3",
                ]
            )
        );

        $this->assertEquals(
            5,
            $returnedValue
        );
    }
}
