<?php

namespace Sid\Framework\Test\Unit;

use Sid\Framework\Url;

class UrlTest extends \Codeception\TestCase\Test
{
    public function testGetBaseUrl()
    {
        $baseUri = "http://www.example.com";



        $url = new Url($baseUri);

        $this->assertEquals(
            $baseUri,
            $url->getBaseUri()
        );
    }

    /**
     * @dataProvider provider
     */
    public function testUrl(string $baseUri, string $expected, string $uri, array $params = [])
    {
        $url = new Url($baseUri);

        $actual = $url->get($uri, $params);



        $this->assertEquals(
            $expected,
            $actual
        );
    }

    public function provider()
    {
        return [
            [
                "baseUri"  => "",
                "expected" => "/",
                "uri"      => "",
            ],

            [
                "baseUri"  => "",
                "expected" => "/",
                "uri"      => "/",
            ],

            [
                "baseUri"  => "",
                "expected" => "/this/is/the/path",
                "uri"      => "this/is/the/path",
            ],

            [
                "baseUri"  => "http://www.example.com",
                "expected" => "http://www.example.com/",
                "uri"      => "",
            ],

            [
                "baseUri"  => "http://www.example.com",
                "expected" => "http://www.example.com/",
                "uri"      => "/",
            ],

            [
                "baseUri"  => "http://www.example.com",
                "expected" => "http://www.example.com/this/is/the/path",
                "uri"      => "/this/is/the/path",
            ],
        ];
    }
}
