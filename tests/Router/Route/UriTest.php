<?php

namespace Sid\Framework\Test\Unit\Router\Route;

use Codeception\TestCase\Test;
use Sid\Framework\Router\Route\Uri;

class UriTest extends Test
{
    public function testGetters()
    {
        $uri = "/{a}/{b}";

        $uriClass = new Uri(
            [
                "value" => $uri,
            ]
        );



        $this->assertEquals(
            $uri,
            $uriClass->getUri()
        );
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testEmptyAnnotation()
    {
        $uri = new Uri(
            []
        );
    }
}
