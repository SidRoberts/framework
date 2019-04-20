<?php

namespace Tests\Router\Route;

use InvalidArgumentException;
use LogicException;
use Sid\Framework\Router;
use Sid\Framework\Router\Route\Converters;
use Tests\UnitTester;

class ConvertersCest
{
    public function testBadConverter(UnitTester $I)
    {
        $I->expectException(
            InvalidArgumentException::class,
            function () {
                $converters = new Converters(
                    [
                        "example" => Router::class,
                    ]
                );
            }
        );
    }

    public function testImmutabilitySet(UnitTester $I)
    {
        $converters = new Converters(
            []
        );

        $I->expectException(
            LogicException::class,
            function () use ($converters) {
                $converters["example"] = null;
            }
        );
    }

    public function testImmutabilityUnset(UnitTester $I)
    {
        $converters = new Converters(
            []
        );

        $I->expectException(
            LogicException::class,
            function () use ($converters) {
                unset($converters["example"]);
            }
        );
    }
}
