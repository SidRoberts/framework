<?php

namespace Tests\Router\Route;

use InvalidArgumentException;
use Sid\Framework\Router\Route\Uri;
use Tests\UnitTester;

class UriCest
{
    public function getters(UnitTester $I)
    {
        $uri = "/{a}/{b}";

        $uriClass = new Uri(
            [
                "value" => $uri,
            ]
        );



        $I->assertEquals(
            $uri,
            $uriClass->getUri()
        );
    }

    public function emptyAnnotation(UnitTester $I)
    {
        $I->expectThrowable(
            InvalidArgumentException::class,
            function () {
                $uri = new Uri(
                    []
                );
            }
        );
    }
}
