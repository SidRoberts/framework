<?php

namespace Sid\Framework\Test\Unit\Kernel\ReturnHandler;

use Sid\Framework\Dispatcher;
use Sid\Framework\Dispatcher\Path;
use Sid\Framework\View;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ImplicitViewTest extends \Codeception\TestCase\Test
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



    /**
     * @dataProvider provider
     */
    public function testHandle($action, $expected)
    {
        $request = Request::create("/");

        $path = new Path(
            \Controller\ImplicitViewController::class,
            $action
        );




        $engine = new \Sid\Framework\View\Engine\Php(
            getcwd() . "/tests/_support/views/"
        );

        $view = new View($engine);



        $response = new Response();



        $container = new \Sid\Container\Container();

        $container->set("view", $view);

        $container->set("response", $response);



        $dispatcher = new Dispatcher($container);



        $returnHandler = new \Sid\Framework\Kernel\ReturnHandler\ImplicitView(
            $view
        );

        $startingValue = $dispatcher->dispatch($path);

        $returnedValue = $returnHandler->handle(
            $request,
            $path,
            $startingValue
        );



        $this->assertEquals(
            $expected,
            $returnedValue
        );
    }

    public function provider()
    {
        return [
            "implicit" => [
                "action"   => "implicit",
                "expected" => "Hello",
            ],

            "returnsString" => [
                "action"   => "returnsString",
                "expected" => "this is a string",
            ],

            "alreadyRendersView" => [
                "action"   => "alreadyRendersView",
                "expected" => "ABC DEF",
            ],
        ];
    }
}
