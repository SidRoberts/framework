<?php

namespace Sid\Framework\Test\Unit\Kernel\ReturnHandler;

use Sid\Container\Container;

use Sid\Framework\Dispatcher\Path;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ResponseTest extends \Codeception\TestCase\Test
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
    public function testHandle($startingValue, $expectedContent)
    {
        $request = Request::create("/");

        $path = new Path(
            \Controller\ParametersController::class,
            "a"
        );



        $container = new Container();

        $response = new Response();

        $container->set("response", $response);



        $returnHandler = new \Sid\Framework\Kernel\ReturnHandler\Response(
            $container
        );

        $returnedValue = $returnHandler->handle(
            $request,
            $path,
            $startingValue
        );



        $this->assertInstanceof(
            Response::class,
            $returnedValue
        );

        $this->assertEquals(
            $expectedContent,
            $returnedValue->getContent()
        );
    }

    public function provider()
    {
        return [
            [
                "startingValue"   => "hello",
                "expectedContent" => "hello",
            ],
            [
                "startingValue"   => new Response("hello"),
                "expectedContent" => "hello",
            ],
        ];
    }
}
