<?php

namespace Tests\Router\Route;

use InvalidArgumentException;
use Sid\Framework\Router;
use Sid\Framework\Router\Route\Middlewares;
use Tests\UnitTester;

class MiddlewaresCest
{
    public function badMiddleware(UnitTester $I)
    {
        $I->expectException(
            InvalidArgumentException::class,
            function () {
                $middlewares = new Middlewares(
                    [
                        "value" => [
                            Router::class,
                        ],
                    ]
                );
            }
        );
    }
}
