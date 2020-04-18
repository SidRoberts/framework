<?php

namespace Tests\Router\Route;

use InvalidArgumentException;
use Sid\Framework\Router\Route\Method;
use Tests\UnitTester;

class MethodCest
{
    public function getters(UnitTester $I)
    {
        $method = "POST";

        $methodClass = new Method(
            [
                "value" => $method,
            ]
        );



        $I->assertEquals(
            $method,
            $methodClass->getMethod()
        );
    }

    public function emptyAnnotation(UnitTester $I)
    {
        $I->expectThrowable(
            InvalidArgumentException::class,
            function () {
                $method = new Method(
                    []
                );
            }
        );
    }
}
