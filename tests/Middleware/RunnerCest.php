<?php

namespace Tests\Middleware;

use Codeception\Example;
use Sid\Framework\Dispatcher\Path;
use Sid\Framework\Middleware\Runner;
use Sid\Framework\Router\Route;
use Sid\Framework\Router\Route\Uri;
use Tests\UnitTester;
use Tests\Controller\IndexController;

class RunnerCest
{
    public function testGetters(UnitTester $I)
    {
        $runner = new Runner();

        $middleware = new \Tests\Middleware\ExampleTrue();



        $I->assertEquals(
            [],
            $runner->getMiddlewares()
        );



        $runner->addMiddleware($middleware);



        $I->assertEquals(
            [
                $middleware
            ],
            $runner->getMiddlewares()
        );
    }



    /**
     * @dataProvider runProvider
     */
    public function testRun(UnitTester $I, Example $example)
    {
        $runner = new Runner();

        foreach ($example["middlewares"] as $middleware) {
            $runner->addMiddleware($middleware);
        }



        $uri = "/";

        $route = new Route(
            new Uri(
                [
                    "value" => $uri,
                ]
            ),
            new Path(
                IndexController::class,
                "index"
            )
        );



        $actual = $runner->run($uri, $route);

        $I->assertEquals(
            $example["expected"],
            $actual
        );
    }



    public function runProvider() : array
    {
        return [
            [
                "expected"    => true,
                "middlewares" => [
                    new \Tests\Middleware\ExampleTrue(),
                ],
            ],

            [
                "expected"    => false,
                "middlewares" => [
                    new \Tests\Middleware\ExampleFalse(),
                ],
            ],

            [
                "expected"    => false,
                "middlewares" => [
                    new \Tests\Middleware\ExampleTrue(),
                    new \Tests\Middleware\ExampleFalse(),
                ],
            ],

            [
                "expected"    => false,
                "middlewares" => [
                    new \Tests\Middleware\ExampleFalse(),
                    new \Tests\Middleware\ExampleTrue(),
                ],
            ],
        ];
    }
}
