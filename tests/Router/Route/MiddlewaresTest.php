<?php

namespace Sid\Framework\Test\Unit\Router\Route;

use Codeception\TestCase\Test;
use InvalidArgumentException;
use Sid\Framework\Router;
use Sid\Framework\Router\Route\Middlewares;

class MiddlewaresTest extends Test
{
    public function testBadMiddleware()
    {
        $this->expectException(
            InvalidArgumentException::class
        );



        $middlewares = new Middlewares(
            [
                "value" => [
                    Router::class,
                ]
            ]
        );
    }
}
