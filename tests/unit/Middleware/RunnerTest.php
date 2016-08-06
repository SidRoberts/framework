<?php

namespace Sid\Framework\Test\Unit\Middleware;

use Sid\Framework\Middleware\Runner;
use Sid\Framework\Router\Route;
use Sid\Framework\Router\Annotations\Route as RouteAnnotation;
use Sid\Framework\Dispatcher\Path;

class RunnerTest extends \Codeception\TestCase\Test
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



        $route = new Route(
            new RouteAnnotation(
                [
                    "value" => "/",
                ]
            ),
            new Path(
                \Controller\IndexController::class,
                "index"
            )
        );



        $this->assertEquals(
            $expected,
            $runner->run(
                [
                    "/",
                    $route
                ]
            )
        );
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
