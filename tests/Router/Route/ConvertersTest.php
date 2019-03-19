<?php

namespace Sid\Framework\Test\Unit\Router\Route;

use Codeception\TestCase\Test;
use InvalidArgumentException;
use LogicException;
use Sid\Framework\Router;
use Sid\Framework\Router\Route\Converters;

class ConvertersTest extends Test
{
    public function testBadConverter()
    {
        $this->expectException(
            InvalidArgumentException::class
        );



        $converters = new Converters(
            [
                "example" => Router::class,
            ]
        );
    }

    public function testImmutabilitySet()
    {
        $this->expectException(
            LogicException::class
        );



        $converters = new Converters(
            []
        );

        $converters["example"] = null;
    }

    public function testImmutabilityUnset()
    {
        $this->expectException(
            LogicException::class
        );



        $converters = new Converters(
            []
        );

        unset($converters["example"]);
    }
}
