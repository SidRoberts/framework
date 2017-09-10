<?php

namespace Sid\Framework\Test\Unit\Kernel\ReturnHandler;

use Sid\Framework\Dispatcher\Path;

use Symfony\Component\HttpFoundation\Request;

class ExitCodeTest extends \Codeception\TestCase\Test
{
    /**
     * @dataProvider provider
     */
    public function testHandle($startingValue, $expected)
    {
        $request = Request::create("/");

        $path = new Path(
            \Controller\ParametersController::class,
            "a"
        );



        $returnHandler = new \Sid\Framework\Kernel\ReturnHandler\ExitCode();

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
            [
                "startingValue" => 0,
                "expected"      => 0,
            ],
            [
                "startingValue" => 1,
                "expected"      => 1,
            ],
            [
                "startingValue" => "0",
                "expected"      => 0,
            ],
            [
                "startingValue" => "1",
                "expected"      => 1,
            ],
            [
                "startingValue" => null,
                "expected"      => 0,
            ],
            [
                "startingValue" => "hello",
                "expected"      => 0,
            ],
        ];
    }
}
