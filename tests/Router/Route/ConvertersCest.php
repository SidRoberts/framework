<?php

namespace Tests\Router\Route;

use InvalidArgumentException;
use LogicException;
use Sid\Framework\Router;
use Sid\Framework\Router\Route\Converters;
use Tests\UnitTester;

class ConvertersCest
{
    public function badConverter(UnitTester $I)
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

    public function immutabilitySet(UnitTester $I)
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

    public function immutabilityUnset(UnitTester $I)
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
