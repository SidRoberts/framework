<?php

namespace Sid\Framework\Test\Unit;

use Symfony\Component\DependencyInjection\ContainerBuilder;

use Sid\Framework\Dispatcher;
use Sid\Framework\Dispatcher\Path;
use Sid\Framework\Resolver;

class DispatcherTest extends \Codeception\TestCase\Test
{
    public function testSimpleDispatch()
    {
        $container = new ContainerBuilder();

        $resolver = new Resolver($container);



        $dispatcher = new Dispatcher($resolver);



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
        $container = new ContainerBuilder();

        $resolver = new Resolver($container);



        $dispatcher = new Dispatcher($resolver);



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
