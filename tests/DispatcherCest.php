<?php

namespace Tests;

use Sid\ContainerResolver\Resolver\Psr11 as Resolver;
use Sid\Framework\Dispatcher;
use Sid\Framework\Dispatcher\Path;
use Sid\Framework\Parameters;
use Symfony\Component\DependencyInjection\Container;
use Tests\Controller\IndexController;
use Tests\Controller\MathController;

class DispatcherCest
{
    public function simpleDispatch(UnitTester $I)
    {
        $container = new Container();

        $resolver = new Resolver($container);



        $dispatcher = new Dispatcher($resolver);



        $returnedValue = $dispatcher->dispatch(
            new Path(
                IndexController::class,
                "index"
            ),
            new Parameters(
                []
            )
        );

        $I->assertEquals(
            "homepage",
            $returnedValue
        );
    }

    public function params(UnitTester $I)
    {
        $container = new Container();

        $resolver = new Resolver($container);



        $dispatcher = new Dispatcher($resolver);



        $returnedValue = $dispatcher->dispatch(
            new Path(
                MathController::class,
                "addition"
            ),
            new Parameters(
                [
                    "a" => 2,
                    "b" => "3",
                ]
            )
        );

        $I->assertEquals(
            5,
            $returnedValue
        );
    }
}
