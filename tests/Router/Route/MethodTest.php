<?php

namespace Sid\Framework\Test\Unit\Router\Route;

use Codeception\TestCase\Test;
use Sid\Framework\Router\Route\Method;

class MethodTest extends Test
{
    public function testGetters()
    {
        $method = "POST";

        $methodClass = new Method(
            [
                "value" => $method,
            ]
        );



        $this->assertEquals(
            $method,
            $methodClass->getMethod()
        );
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testEmptyAnnotation()
    {
        $method = new Method(
            []
        );
    }
}
