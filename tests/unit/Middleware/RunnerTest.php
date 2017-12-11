<?php

namespace Sid\Framework\Test\Unit\Middleware;

use Sid\Framework\Dispatcher\Path;
use Sid\Framework\Middleware\Runner;
use Sid\Framework\Router\Route;
use Sid\Framework\Router\Route\Uri;

class RunnerTest extends \Codeception\TestCase\Test
{
    public function testGetters()
    {
        $runner = new Runner();

        $middleware = new \Middleware\ExampleTrue();



        $this->assertEquals(
            [],
            $runner->getMiddlewares()
        );



        $runner->addMiddleware($middleware);



        $this->assertEquals(
            [
                $middleware
            ],
            $runner->getMiddlewares()
        );
    }



    /**
     * @dataProvider runProvider
     */
    public function testRun(bool $expected, array $middlewares)
    {
        $runner = new Runner();

        foreach ($middlewares as $middleware) {
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
                \Controller\IndexController::class,
                "index"
            )
        );



        $actual = $runner->run($uri, $route);

        $this->assertEquals($expected, $actual);
    }



    public function runProvider()
    {
        return [
            [
                "expected"    => true,
                "middlewares" => [
                    new \Middleware\ExampleTrue(),
                ],
            ],

            [
                "expected"    => false,
                "middlewares" => [
                    new \Middleware\ExampleFalse(),
                ],
            ],

            [
                "expected"    => false,
                "middlewares" => [
                    new \Middleware\ExampleTrue(),
                    new \Middleware\ExampleFalse(),
                ],
            ],

            [
                "expected"    => false,
                "middlewares" => [
                    new \Middleware\ExampleFalse(),
                    new \Middleware\ExampleTrue(),
                ],
            ],
        ];
    }
}
