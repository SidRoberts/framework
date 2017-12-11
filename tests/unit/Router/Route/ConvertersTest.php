<?php

namespace Sid\Framework\Test\Unit\Router\Route;

use Codeception\TestCase\Test;
use Sid\Framework\Router\Route\Converters;

class ConvertersTest extends Test
{
    /**
     * @expectedException InvalidArgumentException
     */
    public function testBadConverter()
    {
        $converters = new Converters(
            [
                "example" => \Sid\Framework\Router::class,
            ]
        );
    }

    /**
     * @expectedException LogicException
     */
    public function testImmutabilitySet()
    {
        $converters = new Converters(
            []
        );

        $converters["example"] = null;
    }

    /**
     * @expectedException LogicException
     */
    public function testImmutabilityUnset()
    {
        $converters = new Converters(
            []
        );

        unset($converters["example"]);
    }
}
