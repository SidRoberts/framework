<?php

namespace Sid\Framework\Test\Unit\Router\Route;

use Codeception\TestCase\Test;
use Sid\Framework\Router\Route\Middlewares;

class MiddlewaresTest extends Test
{
    /**
     * @expectedException InvalidArgumentException
     */
    public function testBadMiddleware()
    {
        $middlewares = new Middlewares(
            [
                "value" => [
                    \Sid\Framework\Router::class
                ]
            ]
        );
    }
}
